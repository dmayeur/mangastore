<template lang="html">
    <div>
        <table>
            <thead>
                <tr>
                    <th
                        v-for="column in header"
                        :key="column.id"
                    >
                        {{column}}
                    </th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="line in body"
                    :key="line.id"
                >
                    <td
                        v-for="value in line"
                        :key="value.id"
                    >
                        {{value}}
                    </td>
                    <td> <router-link :to="$route.path+'/'+line.id">Test</router-link> </td>
                    <td>X</td>
                </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
export default {
    props: {
        header: Array,
        body: Array
    }
}
</script>

<style lang="scss" scoped>
table {
    width:100%;
    text-align:center;
    border:1px solid  #004085;
    color: #004085;

    border-collapse: collapse;
    border-spacing: 0;

    tr {
        border-bottom:1px solid  #004085;
    }
    tr th{
        background-color: $primary-color;
        color: #fff;
    }

    tr:nth-of-type(odd){
        background-color: #fff;
    }

    tr:nth-of-type(even){
        background-color:#CCE5FF;
    }

    td, th {
        padding: 5px;
    }
}
</style>
