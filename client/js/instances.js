let instance = new Vue({
    el: '#instances',
    data: {
        options: {
            package: 'baddies-insight',
            list_api_read: 'instances:list.read',
            form_api_read: 'instances:form.read',
            form_api_create: 'instances:form.create',
            form_api_update: 'instances:form.update',
            form_api_delete: 'instances:form.delete',
            form_storable_key: 'instance_id',
            list_type: 'table',
            list_table_columns: {
                id: 'ID',
                type: 'Type',
                label: 'Raid',
                tier: 'Tier'
            },
            fields: [
                'instance_id',
                'type',
                'label',
                'tier'
            ],
            views: [
                'form'
            ],
        },
        type_options: [],
    },
    methods: {},
    computed: {},
    watch: {},
    created() {

    },
    mounted() {
        DynamicSuite.call('baddies-insight', 'instance_types:read', {}, response => {
            this.type_options = response.data;
        })
    }
});