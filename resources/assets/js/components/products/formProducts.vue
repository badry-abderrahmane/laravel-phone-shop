<template>
  <div>
    <notifications group="products" />
    <part-modal id="modal-form">
      <h4 class="modal-title" slot="title">{{ editing ? 'Edit serie' : 'Add new serie'}}</h4>
      <div  slot="body">
        <form v-on:submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
            <div class="row">
                <div class="col-md-6">
                    <div v-bind:class="{ 'has-error': form.errors.get('name') }">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" v-model="form.name" />
                        <span class="help-block" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div v-bind:class="{ 'has-error': form.errors.get('category_id') }">
                        <label>Category</label>
                        <select class="form-control" name="category_id" v-model="form.category_id" @change="form.errors.clear('category_id')">
                              <option v-for="category in categories" v-bind:value="category.id"> {{ category.name }}</option>
                        </select>
                        <span class="help-block" v-if="form.errors.has('category_id')" v-text="form.errors.get('category_id')"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div v-bind:class="{ 'has-error': form.errors.get('serie_id') }">
                        <label>Serie</label>
                        <select class="form-control" name="serie_id" v-model="form.serie_id" @change="form.errors.clear('serie_id')">
                              <option v-for="serie in series" v-bind:value="serie.id"> {{ serie.name }}</option>
                        </select>
                        <span class="help-block" v-if="form.errors.has('serie_id')" v-text="form.errors.get('serie_id')"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div v-bind:class="{ 'has-error': form.errors.get('shortDesc') }">
                        <label>Short Description</label>
                        <input type="text" name="shortDesc" class="form-control" v-model="form.shortDesc"/>
                        <span class="help-block" v-if="form.errors.has('shortDesc')" v-text="form.errors.get('shortDesc')"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div v-bind:class="{ 'has-error': form.errors.get('longDesc') }">
                        <label>Long Description</label>
                        <textarea type="text" name="longDesc" class="form-control" v-model="form.longDesc"/>
                        <span class="help-block" v-if="form.errors.has('longDesc')" v-text="form.errors.get('longDesc')"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div v-bind:class="{ 'has-error': form.errors.get('imgs') }">
                        <label>Images</label>
                        <input type="text" name="imgs" class="form-control" v-model="form.imgs"/>
                        <span class="help-block" v-if="form.errors.has('imgs')" v-text="form.errors.get('imgs')"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div v-bind:class="{ 'has-error': form.errors.get('links') }">
                        <label>Links</label>
                        <input type="text" name="links" class="form-control" v-model="form.links"/>
                        <span class="help-block" v-if="form.errors.has('links')" v-text="form.errors.get('links')"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div v-bind:class="{ 'has-error': form.errors.get('order') }">
                        <label>Order</label>
                        <input type="text" name="order" class="form-control" v-model="form.order"/>
                        <span class="help-block" v-if="form.errors.has('order')" v-text="form.errors.get('order')"></span>
                    </div>
                </div>
            </div>
            <div class="row"><br>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <button type="submit"
                          v-bind:class="[editing ? 'btn-warning' : 'btn-success', 'btn btn-block']"
                          :disabled="form.errors.any()">{{ editing ? 'Update' : 'Add' }}
                  </button>
                </div>
            </div>
        </form>
      </div>
    </part-modal>

  </div>
</template>



<script>

    import { Form } from '../../api/form.js';

    export default {
        data(){
          return{
            editing: 0,
            form : new Form({
              id: '',
              name: '',
              shortDesc: '',
              longDesc: '',
              imgs: '',
              links: '',
              tags: '',
              order: '',
              state: '',
              category_id: '',
              serie_id: '',
            }),
            series:[],
            categories:[]
          }
        },

        created(){
          this.getSeries();
          this.getCategories();

          Event.$on('edit-product', (product) => {
            this.editing = 1;
            this.form.reset();
            this.form.load(product);
            $('#modal-form').modal('show');
          });

          Event.$on('reset-form', () => {
            this.editing = 0;
            this.form.reset();
          });
        },

        methods: {

          onSubmit(){
            if (this.form.id == '') {
              this.form.post('/admin/products')
                .then(data => {
                  this.refreshList();
                  this.notify('Products management',data.message,'success');
                })
                .catch(errors =>{
                  this.notify('Products management',errors.message,'warn');
                });
            }else{
              this.form.put('/admin/products')
                .then(data => {
                  this.refreshList();
                  this.notify('Products management',data.message,'success');
                })
                .catch(errors => {
                  this.notify('Products management',errors.message,'warn');
                });
            }

          },

          getSeries(){
            axios.get('/admin/series')
                .then(response => {
                    this.series = response.data;
                });
          },
          getCategories(){
            axios.get('/admin/categories')
                .then(response => {
                    this.categories = response.data;
                });
          },

          refreshList(){
              Event.$emit('refresh-list');
              this.quitModal();
          },

          notify(title,message,type){
            this.$notify({
              group: 'foo',
              type: type,
              title: title,
              text: message,
              duration: 10000,
              speed: 1000
            });
          },

          quitModal(){
            $('#modal-form').modal('hide');
            $('.modal-backdrop').attr('class','');
          }

        }
    }



</script>
