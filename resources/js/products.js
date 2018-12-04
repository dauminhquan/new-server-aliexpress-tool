import Vue from 'vue'

var app = new Vue({
    el: "#app",
    props:["length-ids"],
    data(){
        return {
            selectAll: false,
            ids: []
        }
    },
    watch:{
        ids: (value) => {
            if(value.length == this.lengthIds)
            {
                this.selectAll = true
            }
            else{
                this.selectAll = false
            }
        }
    }
})
