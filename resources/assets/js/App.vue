<template>
<div class="offset-1 col-10 offset-sm-1 col-sm-10 ">
 <li class="list-group-item active">Chat room
   <span class="badge badge-pill badge-success">{{pengguna}}</span>
   <a href="" class="btn btn-danger btn-sm float-right" @click.prevent="deleteChat">Delete Chats</a>
 </li>
 <div class="badge badge-pill badge-primary">{{typing}}</div>
 <ul class="list-group " v-chat-scroll>
    <!-- <li class="list-group-item "> -->

  <message 
  v-for="(value, n) in chat.message"
  :key="n"
  :data="value"
  :user="chat.user[n]"
  :color="chat.color[n]"
  :time="chat.time[n]"
  
  ></message>
    <!-- <message v-for="(value, n) in chat.message" :key="n" >@{{value}}</message> -->
    <!-- </li> -->
 </ul>
 <input type="text" class="form-control" placeholder="Type your message here..." v-model="message" @keyup.enter="send" focus>

</div>
</template>
<script>

// Vue.component('message', require('./components/message.vue'));
import message from './components/message.vue'
export default {
 name:'wawan',
 components:{
  message
 }, 
 data(){
  return {
   message:'',
   chat:{
    message:[],
    user:[],
    color:[],
    time:[]
   },
   typing:'',
   pengguna:0
  }
 },
 mounted(){
   this.getOldMessage()
   Echo.private('chat')
    .listen('ChatEvent', (e) => {
    this.chat.message.push(e.message)
    this.chat.user.push(e.user)
    this.chat.color.push('warning')
    this.chat.time.push(this.getTime())
    axios.post('/saveToSession',{chat:this.chat})
        // console.log(e);
    })
    .listenForWhisper('typing', (e) => {
        if(e.name != ''){

        this.typing = 'typing...';
        }else{
        this.typing = '';
        }

    });
    Echo.join(`chat`)
    .here((users) => {
        this.pengguna=users.length
        // console.log(users);
    })
    .joining((user) => {
        this.pengguna+=1
        this.$toaster.success(user.name+' is joined the chat room.')
        // console.log(user.name);
    })
    .leaving((user) => {
        this.pengguna-=1
        this.$toaster.warning(user.name+' is leave the chat room.')
        // console.log(user.name);
    });
 },
 watch:{
   message(){
     Echo.private('chat')
    .whisper('typing', {
        name: this.message
    });
   }
 },
 methods:{
   deleteChat(){
     axios.post('/deleteSession')
     .then(()=>this.$toaster.success('Chat History is deleted'))
   },
  send(){
   if(this.message.length != 0){
    this.chat.message.push(this.message)
    this.chat.color.push('success')
    this.chat.user.push('You')
    this.chat.time.push(this.getTime())
    axios.post('/send',{
      message: this.message,
      chat:this.chat
    })
    .then(res=>{
      // console.log(res)
    this.message = ''
    })
    .catch(err=>{
    this.message = 'sorry I am error'
      console.log(err)
    })
   }
  },
  getTime(){
    let time = new Date()
    // console.log(time.getMinutes().toString())
    // console.log(time.getMinutes().toString().length)
    if(time.getMinutes().toString().length==1){
      return time.getHours()+':0'+time.getMinutes()
    }else{
      // console.log(time.getHours()+':'+time.getMinutes())
    return time.getHours()+':'+time.getMinutes()
    }
  },
  getOldMessage(){
    axios.post('/getOldMessage')
    .then(res=>{
      if(res.data!=''){
        this.chat=res.data
      }
    }) 
  }
 },
 directives: {
  focus: {
    // directive definition
    inserted: function (el) {
      el.focus()
    }
  }
}
}
</script>
<style  scoped>
.list-group{
 overflow-y: auto;
 height: 200px;
 
}
</style>