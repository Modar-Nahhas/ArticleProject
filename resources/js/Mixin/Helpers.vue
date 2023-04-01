<script>

export default {
    name: "Helpers",
    data() {
        return {
            tableOptions: {},
            tableParams: {
                page: 1,
                number: 5,
                sort: 'id',
                sort_desc: true,
                search: '',
                totalRecords: 1,
            },
        }
    },
    methods: {
        showProgress(show = true){
            this.$store.commit('progress',show);
        },
        showNotification(res = null, success = true, warn = true, error = true) {
            if (res.code === 200) {
                if (Boolean(res.result)) {
                    if (success) {
                        let message = res.message ?? 'Success';
                        this.$notify({
                            group: 'public',
                            type: 'success',
                            text: message,
                            duration: 4000
                        })
                    }
                } else {
                    if (warn) {
                        let message = res.message ?? 'Warning';
                        this.$notify({
                            group: 'public',
                            type: 'warn',
                            text: message,
                            duration: 6000
                        })
                    }
                }
            } else {
                if (error) {
                    let message = res.message ?? 'Error';
                    this.$notify({
                        group: 'public',
                        type: 'error',
                        text: message,
                        duration: 8000
                    })
                }
            }
        },
        setTableParameters(serverResponse) {
            this.tableParams.page = serverResponse.data.current_page ?? this.tableParams.page;
            this.tableParams.number = serverResponse.data.per_page ?? this.tableParams.number;
            this.tableParams.totalRecords = serverResponse.data.total ?? this.tableParams.totalRecords;
        },
    }
}
</script>

<style scoped>

</style>
