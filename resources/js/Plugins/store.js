import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        isSignedIn: false,
        user: {
            name:'Test',
            token:'',
            permissions:[],
            role:'admin'
        },
        showProgress:false
    },
    getters:{
        user:(state) =>{
            return state.user;
        },
        showProgress:(state) =>{
            return state.showProgress;
        }
    },
    mutations:{
        progress:(state,show) =>{
            state.showProgress = show;
        }
    }

})
export default store;
