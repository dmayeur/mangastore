<template lang="html">
    <div>
        <table id="table">
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
                    v-for="(line,index) in body"
                    :key="line.id"
                >
                    <td
                        v-for="value in line"
                        :key="value.id"
                    >
                        {{value}}
                    </td>
                    <td> <router-link :to="$route.path+'/'+line.id"><i class="fas fa-pen-fancy"></i></router-link> </td>
                    <td @click="del(index)"><i class="fas fa-trash-alt"></i></td>
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
    },
    methods: {
        del(index) {
            this.$emit('del',this.body[index].id);
        }
    },
    mounted() {
         document.querySelector('.test').DataTable();
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
