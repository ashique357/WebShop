
export default{
    data(){
        let sortOrders = {};
        let columns = [];
        columns.forEach((column) => {
            sortOrders[column.name] = -1;
        });
        return {
            data: [],
            columns: columns,
            sortKey: 'name',
            sortOrders: sortOrders,
            length: 10,
            search: '',
            tableShow: {
                showdata: true,
            },
            pagination: {
                currentPage: 1,
                total: '',
                nextPage: '',
                prevPage: '',
                from: '',
                to: ''
            },
            store:[],
            update:[],
            show:[],
            adminRole:[],
            adminPermission:[],
            permissionMenu:[],
            categories:[],
        }
    },
    created() {
        this.getData();
        this.getAllRoles();
        this.getAllPermission();
        this.getAllPermissionAsMenu();
        this.getAllCategories();
        },
    computed:{
        filteredData() {
            let data = this.data;
            console.log(data);
            if (this.search) {
            data = data.filter((row) => {
                return Object.keys(row).some((key) => {
                return String(row[key]).toLowerCase().indexOf(this.search.toLowerCase()) > -1;
                  })
                });
            }

            let sortKey = this.sortKey;
            let order = this.sortOrders[sortKey] || 1;
            if (sortKey) {
                data = data.slice().sort((a, b) => {
                let index = this.getIndex(this.columns, 'name', sortKey);
                a = String(a[sortKey]).toLowerCase();
                b = String(b[sortKey]).toLowerCase();
                if (this.columns[index].type && this.columns[index].type === 'date') {
                    return (a === b ? 0 : new Date(a).getTime() > new Date(b).getTime() ? 1 : -1) * order;
                } 
                else if (this.columns[index].type && this.columns[index].type === 'number') {
                    return (+a === +b ? 0 : +a > +b ? 1 : -1) * order;
                } 
            else {
                return (a === b ? 0 : a > b ? 1 : -1) * order;
                }
            });
        }
            return data;
        },
        
        paginatedData() {
            return this.paginate(this.filteredData, this.length, this.pagination.currentPage);
        },

    },
    methods:{
        paginate(array, length, pageNumber) {
            this.pagination.from = array.length ? ((pageNumber - 1) * length) + 1 : ' ';
            this.pagination.to = pageNumber * length > array.length ? array.length : pageNumber * length;
            this.pagination.prevPage = pageNumber > 1 ? pageNumber : '';
            this.pagination.nextPage = array.length > this.pagination.to ? pageNumber + 1 : '';
            return array.slice((pageNumber - 1) * length, pageNumber * length);
            },
        resetPagination() {
            this.pagination.currentPage = 1;
            this.pagination.prevPage = '';
            this.pagination.nextPage = '';
            },
        sortBy(key) {
            this.resetPagination();
            this.sortKey = key;
            this.sortOrders[key] = this.sortOrders[key] * -1;
            },
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value)
            },
        
        getData(API_URL) {
            this.$http.get(API_URL, {params: this.tableShow})
            .then(response => {
                this.data = response.data;
                // console.log(this.data);
                console.log(this.pagination.total);
                this.pagination.total = this.data.length;
            })
            .catch(errors => {
            console.log(errors);
            });
        },

        updateData(UpdateURL,data){
            var modalId="#editModal";
            this.$http.post(UpdateURL,data)
            .then(response=>{
                // console.log(response.data);    
                this.closeModal(modalId);
                console.log(this.successSweetAlert());
                this.SuccessToaster();
                this.reload();

            })
            .catch(error=>{
                console.log(error);
                this.closeModal(modalId);
                this.failedSweetAlert();
                this.FailedToaster();
                this.reload();

            })
        },

        storeData(StoreUrl,data){
            this.$http.post(StoreUrl,data)
            .then(response=>{
                // this.closeModal("#createModal");
                // this.successSweetAlert();
                // this.SuccessToaster();
                // this.reload();
            })
            .catch(error=>{
                console.log(error.message);
                // this.closeModal("#createModal");
                // this.failedSweetAlert();
                // this.FailedToaster();
                // this.reload();
            })
        },

        openModal(modalId){
            $(modalId).modal();
        },

        closeModal(modalId){
            $(modalId).modal('hide');
        },

        showModal(modalId,data){
            this.openModal(modalId)
            this.show=data;           
        },

        editModal(modalId,data){
            this.openModal(modalId);
            this.show=data;
        },

        getAllRoles(URL="/api/get-all-roles"){
            this.$http.post(URL)
            .then(resp=>{
                this.adminRole=resp.data.data;
            })
            .catch(errors=>{
                console.log(errors);
            })
        },

        getAllPermission(URL="/api/get-all-permissions-old"){
            this.$http.post(URL)
            .then(resp=>{
                this.adminPermission=resp.data.data;
            })
            .catch(errors=>{
                console.log(errors);
            })
        },

        getAllPermissionAsMenu(URL="/api/get-all-permissions-menu"){
            this.$http.post(URL)
            .then(resp=>{
                this.permissionMenu=resp.data.permission;
                // console.log(resp.data.permission);
            })
            .catch(errors=>{
                console.log(errors);
            })
        },

        getAllCategories(URL="/api/get-all-categories"){
            this.$http.post(URL)
            .then(resp=>{
                this.categories=resp.data.categories;
                // console.log(resp.data.categories);
            })
            .catch(errors=>{
                console.log(errors);
            })
        },

        successSweetAlert(){
            this.$swal({
                title: "Success",
                text: "Good job!!",
                icon: "info",
                showConfirmButton: false,
                timer: 1500,
             });
        },
        failedSweetAlert(){
            this.$swal({
                title: "Failed",
                text: "Error!!",
                icon: "info",
                showConfirmButton: false,
                timer: 1500,
             });
        },

        reload(){
            setTimeout(() => window.location.reload(), 1600);
        },

        SuccessToaster(){
            setTimeout(() => Vue.$toast.open({
                type:'success',
                message:'Successfully done',
                position:'top-right'
            }), 100);
        },

        FailedToaster(){
            setTimeout(() => Vue.$toast.open({
                type:'error',
                message:'Please try again',
                position:'top-right'
            }), 100);
        },

    }
}