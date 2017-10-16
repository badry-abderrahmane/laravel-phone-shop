<template>
  <div>
    <notifications group="optiongroups" />
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
                  <div v-bind:class="{ 'has-error': form.errors.get('desc') }">
                      <label>Description</label>
                      <input type="text" name="desc" class="form-control" v-model="form.desc"/>
                      <span class="help-block" v-if="form.errors.has('desc')" v-text="form.errors.get('desc')"></span>
                  </div>
              </div>
              <div class="col-md-6">
                  <div v-bind:class="{ 'has-error': form.errors.get('order') }">
                      <label>Order</label>
                      <input type="text" name="order" class="form-control" v-model="form.order"/>
                      <span class="help-block" v-if="form.errors.has('order')" v-text="form.errors.get('order')"></span>
                  </div>
              </div>
              <div class="col-md-6">
                  <div v-bind:class="{ 'has-error': form.errors.get('category_id') }">
                      <label>Category</label>
                      <select class="form-control" name="category_id" v-model="form.category_id" @change="form.errors.clear('category_id')">
                            <option v-for="category in categories" v-bind:value="category.id"> {{ category.name }}</option>
                      </select>
                      <!-- <input type="text" name="category_id" class="form-control" v-model="form.category_id"/> -->
                      <span class="help-block" v-if="form.errors.has('category_id')" v-text="form.errors.get('category_id')"></span>
                  </div>
              </div>
          </div>
          <div class="row"><br>
              <div class="col-md-4">

              </div>
              <div class="col-md-4">
                  <button type="submit" class="btn btn-success btn-block" :disabled="form.errors.any()">Save</button>
              </div>
          </div>
      </form>
  </div>
</template>



<script>

    import { Form } from '../../api/form.js';

    export default {
        data(){
          return{
            form : new Form({
              id: '',
              name: '',
              order:'',
              desc: '',
              category_id: ''
            }),
            categories:[]
          }
        },

        created(){
          this.getCategories();

          Event.$on('edit-optiongroup', (optiongroup) => {
            this.form.load(optiongroup);
            $('#modal-form').modal('show');
          });

          Event.$on('reset-form', () => {
            this.form.reset();
          });
        },

        methods: {

          onSubmit(){
            if (this.form.id == '') {
              this.form.post('/admin/optiongroups')
                .then(data => {
                  this.refreshList();
                  this.notify('Galleries management',data.message,'success');
                })
                .catch(errors =>{
                  this.notify('Galleries management',errors.message,'warn');
                });
            }else{
              this.form.put('/admin/optiongroups')
                .then(data => {
                  this.refreshList();
                  this.notify('Galleries management',data.message,'success');
                })
                .catch(errors => {
                  this.notify('Galleries management',errors.message,'warn');
                });
            }

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
