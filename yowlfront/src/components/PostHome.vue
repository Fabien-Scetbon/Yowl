<template>
  <div class="card mb-4 shadow-sm" v-on:click="goEdit(note.id)">
    <div class="card-title d-flex flex-row">
      <i class="fas fa-user-ninja mr-2"></i>
      <div class="mr-2"><strong>Posted by : </strong>{{ note.login }}</div>
      <div>
        <strong>the</strong> {{ note.created_at.slice(0, 10) }}
        <strong>at</strong>
        {{ note.created_at.slice(11, 16) }}
      </div>
    </div>

    <div class="card-body">
      <div class="d-flex flex-row justify-content-between">
        <div class="content">
          <span class="badge bg-secondary">Category : {{ note.category }}</span>
          <h1>{{ note.title }}</h1>
          <p>{{ note.content.slice(0, 300) }}</p>
          <span class="url"><i class="fas fa-link mr-1"></i>{{ note.url }}</span>
        </div>

        <div class="image">
          <img class="shadow-sm" src="../assets/HomeImage.png" alt="photo" />
        </div>
      </div>

    </div>

    <div class="card-footer">
      <span class="like"><i class="far fa-thumbs-up"></i> {{ note.likes_number }}</span>
      <span class="comments"><i class="far fa-comments"></i> {{ note.nbComments }} comments</span>
    </div>
  </div>
</template>

<script>
export default {
  name: "PostHome",
  data() {
    // variables reactives , mises a jour par vue des que modif
   
  },
  props: {
    //L'objet "props" définit quel data est attendu lors du rendu du component
    //recevoir donnee depuis le parent (celui qui appelle ça)
    index: Number,
    key: String,
    note: Object,
  },
  methods: {
    // necessite une intervention de l'user (contrairement a computed)
    goEdit(id) {
      //console.log(id)
      this.$router.push(`/postid/${id}`);
    },
  },
  
};
</script>

<style scoped lang="scss">
.card {
  margin: auto;
  width:50vw;
  max-width: 50vw;
  background-color: #dae0e6;
  cursor: pointer;
}
.card-title {
  background-color: #fff;
  padding: 0.8rem;
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
.card:hover {
  background-color: #a5b2be;
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
  font-size: 0.9rem;
  margin-left: 2rem;
}
</style>