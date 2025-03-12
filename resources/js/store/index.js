import axios from 'axios'
import { isNull } from "lodash"
const state = {
    depositAmount: [],
    memberPercent:[],
    cashDeskAmount:0,
    apiBaseURL: window.school.apiBaseURL,
    isLoading: false,
    categoryList:[],
    advantageList:[],
    retenueList:[],
    serviceList:[],
    divisionList:[],
    agentList:[],
    // mes scripts
    userList:[],
    roleList:[],
    siteList:[],
    memberList:[],
    basicList:[],
    memberReunionList: [],
    memberListContribution: [],
    contributionList:[],

    memberCreditList:[],
    remboursementList:[],

     //debit blog
    paysList:[],
    provinceList:[],
    ListeEdition: [
        { designation: 'Filière 1' },
        { designation: 'Filière 1' },
        { designation: 'Filière 3' },
        
    ],

    formeJuridiqueList:[],
    secteurList:[],
    user2List:[],
    entrepriseList:[],
    projectDetail:null,

    MyCompanyList:[],



    //userType: isNull(window.emerfine.user) ? 'null' : window.emerfine.user.user_type,
}

const getters = {
    depositAmount: state => state.depositAmount,
    cashDeskAmount:state=>state.cashDeskAmount,
    memberPercent:state=>state.memberPercent,
    isloading: (state) => (state.isLoading),
    categoryList:(state)=>(state.categoryList),
    advantageList:(state)=>(state.advantageList),
    retenueList:(state)=>(state.retenueList),
    serviceList:(state)=>(state.serviceList),
    divisionList:(state)=>(state.divisionList),
    agentList:(state)=>(state.agentList),

    // mes scripts
    userList:(state)=>(state.userList),
    roleList:(state)=>(state.roleList),
    siteList:(state)=>(state.siteList),
    memberList:(state)=>(state.memberList),
    basicList:(state)=>(state.basicList),
    reunionList:(state)=>(state.reunionList),

    memberReunionList:(state)=>(state.memberReunionList),

    memberListContribution:(state)=>(state.memberListContribution),
    contributionList:(state)=>(state.contributionList),
    memberCreditList:(state)=>(state.memberCreditList),
    remboursementList:(state)=>(state.remboursementList),

    //debit blog
    paysList:(state)=>(state.paysList),
    provinceList:(state)=>(state.provinceList),
    ListeEdition: (state) => state.ListeEdition,

    formeJuridiqueList:(state)=>(state.formeJuridiqueList),
    secteurList:(state)=>(state.secteurList),
    
    user2List:(state)=>(state.user2List),
    entrepriseList:(state)=>(state.entrepriseList),
    projectDetail: (state) => state.projectDetail,

    MyCompanyList:(state)=>(state.MyCompanyList),

    
    
    
    
    
    

}

const actions = {

    async getAgent({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_member_name`)
            .then(({ data }) => {
                commit('SET_AGENT', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getDivision({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_division`)
            .then(({ data }) => {
                commit('SET_DIVISION', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },
    async getService({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_service`)
            .then(({ data }) => {
                commit('SET_SERVICES', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getRetenu({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_retenu`)
            .then(({ data }) => {
                commit('SET_RETENU', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getAdvantages({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_advantage`)
            .then(({ data }) => {
                commit('SET_ADVANTAGES', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getCategory({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_categories`)
            .then(({ data }) => {
                commit('SET_CATEGORIES', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getMemberPercent({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_percents`)
            .then(({ data }) => {
                commit('SET_MEMBER_PERCENT', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getDepositAmount({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/desposit_amount`)
            .then(({ data }) => {
                commit('SET_DEPOSIT_AMOUNT', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },
    async getCashDesk({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_amount`)
            .then(({ data }) => {
                commit('SET_CASH_DESK', data.data[0].amount)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    //mes scripts
    async getUser({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_user`)
            .then(({ data }) => {
                commit('SET_USER', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getRole({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_role`)
            .then(({ data }) => {
                commit('SET_ROLE', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getSite({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_site`)
            .then(({ data }) => {
                commit('SET_SITE', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getMember({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_member_name`)
            .then(({ data }) => {
                commit('SET_MEMBER', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getBasic({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_basic`)
            .then(({ data }) => {
                commit('SET_BASIC', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getReunion({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_reunion`)
            .then(({ data }) => {
                commit('SET_REUNION', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getMemberReunion({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_member_name_reunion`)
            .then(({ data }) => {
                commit('SET_MEMBER_REUNION', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getMemberListContribution({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_member_name_contributeur`)
            .then(({ data }) => {
                commit('SET_MEMBER_LIST_CONTRIBUTION', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getContribution({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_contribution`)
            .then(({ data }) => {
                commit('SET_CONTRIBUTION', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getMemberListCredit({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/get_member_name_credit`)
            .then(({ data }) => {
                commit('SET_MEMBER_LIST_CREDIT', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getRemboursement({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_remboursement`)
            .then(({ data }) => {
                commit('SET_REMBOURSEMENT', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    //blog agent
    async getPays({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/ad1/fetch_pays_2`)
            .then(({ data }) => {
                commit('SET_PAYS', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },
    async getCategorie({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/ad1/fetch_list_categorie`)
            .then(({ data }) => {
                commit('SET_CATEGORIE', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getProvince({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/ad1/fetch_province_2`)
            .then(({ data }) => {
                commit('SET_PROVINCE', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getUser2({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_user_ceo`)
            .then(({ data }) => {
                commit('SET_USER_2', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getFormejuridique({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_forme_juridiques_2`)
            .then(({ data }) => {
                commit('SET_FORMEJURIDIQUE', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getSecteurList({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_secteur_2`)
            .then(({ data }) => {
                commit('SET_SECTEUR', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getEntrepriseList({ commit }) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_entreprise_2`)
            .then(({ data }) => {
                commit('SET_ENTREPRISE', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },

    async getProjectInfos({ commit }, slug) {
        commit("SET_LOADING_STATUS");
        await axios
            .get(`${this.state.apiBaseURL}/get_project_infos/${slug}`)
            .then(({ data }) => {
                commit("GET_PROJECT_DETAIL", data.projectDetail);
                commit("SET_LOADING_STATUS");
            })
            .catch((error) => console.log(error));
    },

    async getMyEntrepriseList({ commit }, ceo) {
        commit('SET_LOADING_STATUS')
        await axios.get(`${this.state.apiBaseURL}/fetch_myentreprise/${ceo}`)
            .then(({ data }) => {
                commit('SET_MY_ENTREPRISE', data.data.data)
                commit('SET_LOADING_STATUS')
            }).catch((error) => console.log(error))
    },


    




}
//update data
const mutations = {
    SET_LOADING_STATUS: (state) => (state.isLoading = !state.isLoading),
    SET_DEPOSIT_AMOUNT: (state, depositAmount) => (state.depositAmount = depositAmount),
    SET_CASH_DESK:(state,cashDeskAmount)=>(state.cashDeskAmount=cashDeskAmount),
    SET_MEMBER_PERCENT:(state,memberPercent)=>(state.memberPercent=memberPercent),

    SET_CATEGORIES:(state,categoryList)=>(state.categoryList=categoryList),
    SET_ADVANTAGES:(state,advantageList)=>(state.advantageList=advantageList),
    SET_RETENU:(state,retenueList)=>(state.retenueList=retenueList),
    SET_SERVICES:(state,serviceList)=>(state.serviceList=serviceList),
    SET_DIVISION:(state,divisionList)=>(state.divisionList=divisionList),
    SET_AGENT:(state,agentList)=>(state.agentList=agentList),

    //mes scripts
    SET_USER:(state,userList)=>(state.userList=userList),
    SET_ROLE:(state,roleList)=>(state.roleList=roleList),
    SET_SITE:(state,siteList)=>(state.siteList=siteList),
    SET_MEMBER:(state,memberList)=>(state.memberList=memberList),
    SET_BASIC:(state,basicList)=>(state.basicList=basicList),
    SET_REUNION:(state,reunionList)=>(state.reunionList=reunionList),
    SET_MEMBER_REUNION:(state,memberReunionList)=>(state.memberReunionList=memberReunionList),

    SET_MEMBER_LIST_CONTRIBUTION:(state,memberListContribution)=>(state.memberListContribution=memberListContribution),
    SET_CONTRIBUTION:(state,contributionList)=>(state.contributionList=contributionList),
    
    SET_MEMBER_LIST_CREDIT:(state,memberCreditList)=>(state.memberCreditList=memberCreditList),
    SET_REMBOURSEMENT:(state,remboursementList)=>(state.remboursementList=remboursementList),
    
     //blog agent assurence
    SET_PAYS:(state,paysList)=>(state.paysList=paysList),
    SET_CATEGORIE:(state,categorieList)=>(state.categorieList=categorieList),
    SET_PROVINCE:(state,provinceList)=>(state.provinceList=provinceList),
    SET_FORMEJURIDIQUE:(state,formeJuridiqueList)=>(state.formeJuridiqueList=formeJuridiqueList),
    SET_SECTEUR:(state,secteurList)=>(state.secteurList=secteurList),
    SET_USER_2:(state,user2List)=>(state.user2List=user2List),
    SET_ENTREPRISE:(state,entrepriseList)=>(state.entrepriseList=entrepriseList),
    GET_PROJECT_DETAIL: (state, projectDetail) =>
    (state.projectDetail = projectDetail),

    SET_MY_ENTREPRISE:(state,MyCompanyList)=>(state.MyCompanyList=MyCompanyList),

    
    



}

export default {
    state,
    getters,
    actions,
    mutations
}