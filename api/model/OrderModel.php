<?php

class OrderModel extends CoreModel {
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getAll() {
        $query = "SELECT orders.id, username, order_date, total_order_price, status from orders
        LEFT JOIN users ON users.id = orders.user_id
        LEFT JOIN orderlines ON orderlines.order_id = orders.id
        LEFT JOIN mangas ON mangas.id = orderlines.manga_id
        LEFT JOIN series on mangas.serie_id = series.id
        LEFT JOIN prices on series.price_code = prices.code
        GROUP BY orders.id
        ";

        return $this->db->getQuery($query);
    }

    public function getItems($id) {
        $query = " SELECT mangas.id, series.name as serie, volume, quantity, price,  mangas.image FROM mangas
        LEFT JOIN orderlines ON orderlines.manga_id = mangas.id
        LEFT JOIN series ON series.id = mangas.serie_id
        LEFT JOIN prices ON series.price_code = prices.code
        WHERE order_id = ?
        ";



        return $this->db->getQuery($query, [$id]);
    }

    public function getById($id) {
        $query = "SELECT orders.id, username, order_date, total_order_price, status from orders
        LEFT JOIN users ON users.id = orders.user_id
        LEFT JOIN orderlines ON orderlines.order_id = orders.id
        LEFT JOIN mangas ON mangas.id = orderlines.manga_id
        LEFT JOIN series on mangas.serie_id = series.id
        LEFT JOIN prices on series.price_code = prices.code
        WHERE orders.id = ?
        GROUP BY orders.id
        ";

        return $this->db->getQueryOne($query,[$id]);
    }

    public function create($id, $date, $orderPrice, $status) {
        $query = "INSERT INTO orders (user_id, order_date, total_order_price, status)
                 VALUES (?, ?, ?, ?)
        ";

        return $this->db->postQuery($query,[$id, $date, $orderPrice, $status]);
    }

    public function createOrderline($orderId, $mangaId, $quantity) {
        $query = "INSERT INTO orderlines (order_id, manga_id, quantity)
                 VALUES (?, ?, ?)
        ";

        return $this->db->postQuery($query,[$orderId, $mangaId, $quantity]);
    }


    /**
     * [getTotalPrice get the total price based on the orderlines]
     * used for putting total_price in the orders table doing a single get query
     * vs doing it for every line from the body items
     */
    public function getTotalPrice($orderId) {
        $query = "SELECT SUM(quantity * price) as total_price from orders
        LEFT JOIN orderlines ON orderlines.order_id = orders.id
        LEFT JOIN mangas ON mangas.id = orderlines.manga_id
        LEFT JOIN series on mangas.serie_id = series.id
        LEFT JOIN prices on series.price_code = prices.code
        WHERE orders.id = ?
        GROUP BY orders.id
        ";

        return $this->db->getQueryOne($query, [$orderId]);
    }

    public function changeTotalPrice($price, $orderId) {
        $query = "UPDATE orders
                 SET total_order_price = ?
                 WHERE id = ?";

        return $this->db->executeSQL($query,[$price,$orderId]);
    }

    public function modify($orderId, $status) {
        $query = "UPDATE orders
                SET status = ?
                WHERE id = ?
        ";

        return $this->db->executeSQL($query,[$status,$orderId]);
    }

    public function delete($orderId) {
        $query = " DELETE FROM orders
                WHERE id = ?
        ";

        return $this->db->executeSQL($query, [$orderId]);
    }

}
