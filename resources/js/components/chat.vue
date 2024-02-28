<template>
	<div  class="chat card">
		<div  class="scrollable card-body" ref="hasScrolledToBottom">
	        <template  v-for="message in messages">
	            <div  style="color:grey;margin-top: 0px;background-color: bisque;border: 2px solid azure;
 
 border-radius: 5% 25%;max-width:50%; word-break: break-word;" class="message message-receive" v-if="user.id != message.user.id">
	                <p style="background-color:antiquewhite;" >
						
	                    <!-- <strong  class="primary-font">
	                        {{ message.user.name }} :
	                    </strong> -->
                        <span style="background-color:antiquewhite" >
                            {{ message.message }}
                        </span>

	                </p>
	            </div>
	            <div style=" float: right;color:azure;margin-top: 0px;background-color: royalblue;border: 2px solid royalblue;
 
 border-radius: 5% 25%;max-width:50%;" class="message message-send" v-else>
					
	                <p >
	                    <!-- <strong  class="primary-font">
	                        {{ message.user.name }} :
	                    </strong> -->
	                    {{ message.message }}
	                </p>
	            </div>
				<br>
				<br>
				
	        </template>
			<br>
	    </div>

	    <div class="chat-form input-group">
	        <input id="btn-input" type="text" name="message" class="form-control input-sm message-" placeholder="Type your message here..." v-model="newMessage" @keyup.enter="addMessage">

	        <span class="input-group-btn">
	            <button class="btn btn-primary" id="btn-chat" @click="addMessage">
	                Send
	            </button>
	        </span>
	    </div>

	</div>
</template>
<script>
	import { reactive, inject,ref, onMounted,onUpdated } from 'vue';
	import axios from 'axios';
	export default{
		props:['user','id','target_id','chat_id'],
	    setup(props){
	    	let messages = ref([])
	    	let newMessage = ref('')
	    	let hasScrolledToBottom = ref('')

	    	onMounted(() =>{
	    		fetchMessages()
	    	})

	    	onUpdated(() => {
	    		scrollBottom()
	    	})

	    	Echo.private('chat-channel.'+props.id +'.'+props.user.id)
	          .listen('SendMessage', (e) => {
	            messages.value.push({
	              message: e.message.message,
	              user: e.user
	            });
	        })



	    	const fetchMessages = async()=> {
	            axios.get('/messages/'+props.id).then(response => {
	                messages.value = response.data;
	            });
	        }

	        const addMessage = async()=> {
	        	let user_message = {
                    user: props.user,
                    message: newMessage.value,
                    receiver_id:props.id
                };
	            messages.value.push(user_message);
	            axios.post('/messagestore', user_message).then(response => {
	              console.log(response.data);
	            });
                newMessage.value = ''
	        }

	        const scrollBottom = () =>{
	        	if(messages.value.length > 1){
		        	let el = hasScrolledToBottom.value;
	      			el.scrollTop = el.scrollHeight;
	        	}
	        }

	        return {
	        	messages,
	        	newMessage,
	        	addMessage,
	        	fetchMessages,
	        	hasScrolledToBottom
	        }
	    }
	}
</script>
