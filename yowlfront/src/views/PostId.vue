<template>
  <div>
    <Navbar />

    <div class="flex justify-center mt-4">
      <router-link
        to="/postyourarticle"
        tag="button"
        class="bg-yellow-500 mx-4 text-grey-800 font-bold py-2 px-4 border shadow-lg rounded-lg"
      >
        Post your Article
      </router-link>
    </div>

    <div class="card mt-4 mb-4 shadow-sm">
      <div class="card-title d-flex flex-row align-items-center">
        <div class="header"><img :src="faceurl" alt="photo" /></div>

        <div>
          <div class="mr-2">
            <strong>Posted by : </strong>{{ content.login }}
          </div>
          <div>
            <small
              ><strong>The</strong> {{ content.created_at1 }}
              <strong>at</strong>
              {{ content.created_at2 }}</small
            >
          </div>
        </div>
      </div>

      <div class="card-body">
        <div class="d-flex flex-row justify-content-between">
          <div class="content">
            <span class="badge bg-secondary"
              >Category : {{ content.category }}</span
            >
            <h1>{{ content.title }}</h1>
            <p>{{ content.content }}</p>
            <span class="url"
              ><i class="fas fa-link mr-1"></i>{{ content.url }}</span
            >
          </div>
          <div class="image">
            <img class="shadow-sm" src="../assets/HomeImage.png" alt="photo" />
          </div>
        </div>
      </div>
      <div class="card-footer">
        <span class="like">
          <i
            id="likebutton"
            class="fas fa-heart"
            style="font-size: 1.5rem"
            :style="`color: ${likeColor}`"
            @click="goLike()"
          ></i>
          {{ likeNb }}
        </span>
        <span class="comments"
          ><i class="far fa-comments"></i>
          {{ content.nbComments }} comments</span
        >
      </div>
    </div>

    <div class="card details">
      <div class="card-title">
        <h3>Comments :</h3>
      </div>

      <div class="card-body">
        <div class="card-text" v-for="comm in comms" :key="comm.id">
          <div class="comment" v-if="content.id == comm.post_id">
            <div>
              <small
                ><strong>Posted by </strong>{{ comm.login }}
                <strong>the</strong> {{ comm.created_at.slice(0, 10) }}
                <strong>at</strong> {{ comm.created_at.slice(11, 16) }}</small
              >
              <hr />
              <p :comm="comm">{{ comm.content }}</p>
            </div>
          </div>
        </div>

        <Form @submit="handleComment" :validation-schema="schema">
          <div class="">
            <Field
              name="content"
              placeholder="Enter your comment"
              type="text"
              as="textarea"
              class=""
            />
            <ErrorMessage name="title" class="error-feedback" />
            <div class="button-container">
              <button type="submit" class="btn btn-secondary">Save</button>
            </div>
          </div>
        </Form>
      </div>
    </div>
  </div>
</template>

<script>
import * as yup from 'yup'
import { Form, Field, ErrorMessage } from 'vee-validate'

import PostsService from '../services/posts.service'
import CommentsService from '../services/comments.service'
import Navbar from '../components/Navbar.vue'

export default {
  name: 'PostId',

  components: {
    Navbar,
    Form,
    Field,
    ErrorMessage,
  },
  data() {
    const schema = yup.object().shape({
      content: yup.string().required('Content is required!'),
    })
    return {
      loading: false,
      message: '',
      schema,
      content: {},
      comms: [],
      faceurl: '',
      likeColor: 'rgb(28, 96, 160)',
      likeNb: '',
    }
  },
  computed: {
    get(id) {
      return this.$store.getters.getPostbyid(id)
    },
    getAllComments() {
      return this.$store.getters.getAllComments
    },
    userId() {
      return this.$store.getters['auth/getAuthId']
    },
  },

  mounted() {
    let id = this.$route.params.id
    //console.log(id)

    PostsService.get(id).then(
      (response) => {
        this.content = response.data.post
        //console.log(this.content)
        //console.log(typeof this.content.created_at)
        this.content.created_at1 = this.content.created_at.slice(0, 10)
        this.content.created_at2 = this.content.created_at.slice(11, 16)
        this.likeNb = this.content.likes_number
      },
      (error) => {
        this.content =
          (error.response &&
            error.response.data &&
            error.response.data.message) ||
          error.message ||
          error.toString()
      }
    )

    CommentsService.getAll().then(
      (response) => {
        this.comms = response.data.comments
        //console.log(this.comms)
        //console.log(this.comms[0].login)
      },
      (error) => {
        this.content =
          (error.response &&
            error.response.data &&
            error.response.data.message) ||
          error.message ||
          error.toString()
      }
    )
  },
  methods: {
    handleComment(data) {
      const obj = {
        ...data,
        user_id: this.$store.getters['auth/getAuthId'],
        post_id: parseInt(this.content.id),
      }
      this.loading = true
      //console.log(obj)
      this.$store.dispatch('comment/addCommentItem', obj).then(
        () => {
          location.reload()
        },
        (error) => {
          this.loading = false
          this.message =
            (error.response &&
              error.response.data &&
              error.response.data.message) ||
            error.message ||
            error.toString()
        }
      )
    },
    displayFace() {
      fetch('https://randomuser.me/api/')
        .then((res) => res.json())
        .then((data) => {
          // console.log(data.results[0].picture.medium)
          this.faceurl = data.results[0].picture.medium
        })
    },
    goLike() {
      let likeButton = document.querySelector('#likebutton')
      // console.log(likeButton)
      if (likeButton.classList.contains('fa-thumbs-up')) {
        likeButton.classList.toggle('fa-thumbs-up')
        this.likeColor = 'rgb(28, 96, 160)'
        this.likeNb--
      } else {
        likeButton.classList.toggle('fa-thumbs-up')
        this.likeColor = 'green'
        this.likeNb++
      }
    },
  },
  created: function () {
    this.displayFace()
  },
}
</script>

<style scoped lang="scss">
textarea {
  border: solid 1px #56616d;
  font-size: 1rem;
  padding: 0.4rem;
  width: 100%;
}
.card {
  margin: auto;
  max-width: 50vw;
  background-color: #dae0e6;
}
.card-title {
  background-color: #fff;
  padding: 0.8rem;
}
.header img {
  margin-right: 1rem;
  height: 5rem;
  border-radius: 50%;
}
.content {
  width: 60%;
}
.image {
  width: 40%;
  margin-right: 1rem;
}
.badge {
  margin-bottom: 0.8rem;
  font-size: 0.8rem;
  font-weight: normal;
}
h1 {
  font-weight: 600;
  color: #56616d;
  margin-bottom: 0.8rem;
}
p {
  word-break: break-all;
}
.url {
  font-size: 0.9rem;
  color: #e66604;
}
.fa-user-ninja {
  font-size: 2rem;
}
img {
  margin-left: 1rem;
}
.like {
  font-size: 0.8rem;
}
.comments {
  font-size: 0.8rem;
  margin-left: 2rem;
}
.comment {
  font-size: 0.8rem;
}
.comment p {
  margin-bottom: 1rem;
}
.details {
  background-color: #fff;
}
.details .card-title {
  background-color: #dae0e6;
}
</style>
