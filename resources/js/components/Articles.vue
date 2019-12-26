<template>
  <div>
    <h2>Articles</h2>
    <!-- Form -->
    <form @submit.prevent="addArticle()" class="mb-3">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Title" v-model="article.title">
      </div>
      <div class="form-group">
        <textarea type="text" class="form-control" placeholder="Body" v-model="article.body"></textarea>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Save</button>
    </form>

    <!-- List articles -->
    <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
      <h3>{{ article.title }}</h3>
      <p>{{ article.body }}</p>
      <hr>
      <!-- edit button -->
      <button @click="editArticle(article)" class="btn btn-warning mb-2">Edit</button>
      <!-- delete button -->
      <button @click="deleteArticle(article.id)" class="btn btn-danger">Delete</button>
    </div>

     <!-- Pagination -->
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
          <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a>
        </li>
        
        <li class="page-item disabled"><a class="page-link text-dark" href="#">
          Page {{pagination.current_page}} of {{pagination.last_page}}</a>
        </li>

        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
          <a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  data(){
    return {
      articles: [],
      article: {
        id: '',
        title: '',
        body: ''
      },
      article_id: '',
      pagination: {},
      edit: false
    }
  },

  created(){
    this.fetchArticles()
  },

  methods: {
    fetchArticles(page_url){
      let vm = this;
      page_url = page_url || 'api/articles'
      axios.get(page_url)
        .then(response => {
          this.articles = response.data.data;
          vm.makePagination(response.data.links, response.data.meta);
        })
        .catch(err => console.log(err));
    },

    makePagination(links, meta){
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      }

      this.pagination = pagination;
    },

    deleteArticle(id){
      if(confirm('Are you sure you want to delete?')){
        axios.delete(`api/article/${id}`)
        .then(response => {
          alert('Article removed');
          this.fetchArticles();
        })
        .catch(err => console.log(err));
      }
    },

    addArticle(){
      if(this.edit === false){
        //Add
        axios.post('api/article/', this.article)
        .then(response => {
          this.article.title = '';
          this.article.body = '';
          alert('Article added');
          this.fetchArticles();
        })
      }
      else{
        // update
        axios.put('api/article/', this.article)
        .then(response => {
          this.article.title = '';
          this.article.body = '';
          alert('Article updated');
          this.fetchArticles();
        })
      }
    },
    // populate the form with data
    editArticle(article){
      this.edit = true;
      this.article.id = article.id;
      this.article.article_id = article.id;
      this.article.title = article.title;
      this.article.body = article.body;
    }

  }
}
</script>