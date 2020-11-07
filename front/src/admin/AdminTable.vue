<template lang="html">
    <div class="table-container">
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th
                        v-for="column in header"
                        :key="column.id"
                    >
                        {{column}}
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(line,index) in body"
                    :key="line.id"
                >
                    <td
                        v-for="value in line"
                        :key="value"
                    >
                        {{value || "-"}}
                    </td>
                    <td v-if="modify">
                        <router-link :to="$route.path+'/'+line.id"><i class="fas fa-pen-fancy"></i></router-link>
                        <i class="fas fa-trash-alt" @click="del(index)"></i>
                    </td>
                    <td v-else>
                        <i class="fas fa-trash-alt" @click="del(index)"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</template>

<script>

export default {
    props: {
        header: Object,
        body: Object,
        modify: Boolean
    },
    methods: {
        del(index) {
            this.$emit('del',this.body[index].id,index);
        }
    }
}
</script>

<style lang="scss" scoped>
.table-container {
    overflow-x: auto;
}

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

    .fa-trash-alt {
        @include red-icon;
    }

    .fa-pen-fancy {
        @include green-icon;
    }
}
</style>
