<template>
<div>
    <li class="list-group-item " :class="warna">{{data}}
        <span id="time">{{time}}</span>
    </li>    
    <small class="badge float-right" :class="badgeWarna">{{user}}</small>
</div>
</template>

<script>
    export default {
        name:'message',
        props:{data:String, color:String, user:String, time:String},
        computed:{
            warna(){
                return 'list-group-item-'+this.color
            },
            badgeWarna(){
                return 'badge-'+this.color
                
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        
    }
</script>
<style scoped>
#time{
    font-size: 9px;
    margin-top: 15px;
    margin-left: 5px;
    color: black;
}
</style>
