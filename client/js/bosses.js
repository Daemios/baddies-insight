let bosses = new Vue({
    el: '#bosses',
    data: {
        options: {
            package: 'baddies-insight',
            list_api_read: 'bosses:list.read',
            form_api_read: 'bosses:form.read',
            form_api_create: 'bosses:form.create',
            form_api_update: 'bosses:form.update',
            form_api_delete: 'bosses:form.delete',
            form_storable_key: 'boss_id',
            list_type: 'table',
            list_table_columns: {
                id: 'Boss ID',
                label: 'Label',
                instance_id: 'Instance ID'
            },
            fields: [
                'boss_id',
                'label',
                'instance_id'
            ],
            views: [
                'form'
            ]
        },
        type_options: []
    },
    methods: {},
    computed: {},
    watch: {},
    created() {

    },
    mounted() {
        DynamicSuite.call('baddies-insight', 'instances.read', {}, response => {
            console.log(response)
            this.type_options = response.data;
        })
    }
});