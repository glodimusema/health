import {
    isNull
} from "lodash"

export default {
    data() {
        return {
            baseURL: window.school.baseURL,
            apiBaseURL: window.school.apiBaseURL,
            userData: window.school.user,
            roless: window.school.roless,
            pagination: {
                current: 1,
                total: 0,
            },
            Uri: '',
           
        }
    },
    methods: {
        //fetch data, make pagination 
        //make search
        //async
        //await
        async fetch_data(url) {

            if (this.query != '') {
                this.Uri = url + 1 + "&query=" + this.query
                if (typeof (this.query) === "object") {
                    this.Uri = url + this.pagination.current + "&query="
                    console.log('oobj')
                }
            } else {
                this.Uri = url + this.pagination.current + "&query=" + this.query
            }

            this.makeTrue()
            await axios
                .get(this.Uri)
                .then((res) => {
                    this.fetchData = res.data.data.data;
                    this.pagination.current = res.data.data.current_page;
                    this.pagination.total = res.data.data.last_page;
                    this.makeFalse()
                }).catch((err) => {
                    this.errMsg()
                    console.log(err)
                })
        },

        insertOrUpdate(url, data) {
            const config = {
                headers: {
                    'Content-Type': 'application/json',
                }
            }
            return new Promise((resolve, reject) => {
                axios.post(url, data, config)
                    .then((res) => {
                        resolve(res)
                    })
                    .catch((err) => {
                        this.errMsg()
                        reject(err)
                    })
            })
        },


        //delete
        delGlobal(url) {
            return new Promise((resolve, reject) => {
                this.makeTrue()
                axios.get(url).then((res) => {
                    resolve(res)
                    this.makeFalse()
                }).catch((err) => {
                    this.errMsg(err)
                    this.makeFalse()
                    reject(err)
                })
            })

        },
        //get data based on id 
        //fetch data 
        async editOrFetch(url) {
            return await new Promise((resolve, reject) => {
                this.makeTrue()
                axios.get(url).then((res) => {
                    resolve(res)
                    this.makeFalse()
                }).catch((err) => {
                    this.errMsg()
                    this.makeFalse()
                    reject(err)
                })
            })
        },

       

        makeTrue() {
            this.loading = true
            this.disabled = true
        },
        makeFalse() {
            this.loading = false
            this.disabled = false
        },

        isLoading(bool) {
            this.loading = bool
            this.disabled = bool
        },

        //show message toast plugin
        //toasted-primary
        //bubble
        //outline
        showMsg(msg) {
            this.$toasted.show(msg, {
                icon: 'info',
                action: {
                    text: 'Fermer',
                    onClick: (e, toastObject) => {
                        toastObject.goAway(0);
                    },
                },
                theme: "toasted-primary",
                position: "bottom-right",
                duration: 8000
            });
        },

        svErr() {
            this.$toasted.show('veuillez vérifier si vous êtes connecté !', {
                icon: 'info',
                action: {
                    text: 'Fermer',
                    onClick: (e, toastObject) => {
                        toastObject.goAway(0);
                    },
                },
                theme: "bubble",
                position: "top-right",
                duration: 6000
            });
        },

        showError(msg) {
            this.$toasted.show(msg, {
                icon: 'info',
                action: {
                    text: 'Fermer',
                    onClick: (e, toastObject) => {
                        toastObject.goAway(0);
                    },
                },
                theme: "bubble",
                position: "bottom-right",
                duration: 8000
            });
        },

        errMsg() {
            this.$swal({
                title: "Erreur!",
                text: "Veuillez vérifier si vous êtes connecté.",
                icon: "error",
                confirmButtonText: "Ok",
            });
        },

        confirmMsg() {
            return new Promise((resolve, reject) => {
                this.$swal.fire({
                    title: "êtes-vous sûr ?",
                    text: "Voulez-vous vraiment supprimer !",
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Continuer !",
                    denyButtonText: `Annuler`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        resolve(result.isConfirmed)
                    } else if (result.isDenied) {
                        console.log('annuler')
                    }

                });
            })
        },
        confirmLoss(msg) {
            return new Promise((resolve, reject) => {
                this.$swal.fire({
                    title: "êtes-vous sûr ?",
                    text: msg,
                    icon: "warning",
                    showDenyButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Continuer !",
                    denyButtonText: `Annuler`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        resolve(result.isConfirmed)
                    } else if (result.isDenied) {
                        console.log('annuler')
                    }

                });
            })
        },

        successMsg(msg) {
            this.$swal.fire("suppresion", msg, "success");
        },
        showActiveMsg(msg) {
            this.$swal.fire("Activation", msg, "success");
        },
        resetObj(svData) {
            for (let key in svData) {
                svData[key] = ""
            }
        },
        //get server data object data and give to svData ==> is an object
        getSvData(obj1, obj2) {
            for (let key in obj1) {
                for (let key in obj2) {
                    obj1[key] = obj2[key]
                }
            }
        },
        clearArray(array) {
            let i = 0;
            while (i < array.length) {
                array.pop();
            }
        },




    },
    filters: {
        subStr(value) {
            if (value.length > 2) {
                return value.slice(0, 1).toLowerCase();
            } else {
                return value;
            }
        },
        getMontName(date) {
            return new Date(date).toLocaleString('default', {
                month: 'long'
            })
        },
        formatDate(date) {
            return new Date(date).toLocaleDateString()
        },
        formatHour(date) {
            return new Date(date).toLocaleTimeString()
        },
        LowerCase(value) {
            return value.toLowerCase()
        }
    },

}
