<template>
  <div>
    <notifications group="accessories" />
    <part-modal id="modal-form">
      <h4 class="modal-title" slot="title">{{ editing ? 'Edit accessory' : 'Add new accessory'}}</h4>
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
                    <div v-bind:class="{ 'has-error': form.errors.get('link') }">
                        <label>Link</label>
                        <input type="text" name="link" class="form-control" v-model="form.link"/>
                        <span class="help-block" v-if="form.errors.has('link')" v-text="form.errors.get('link')"></span>
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
                    <div v-bind:class="{ 'has-error': form.errors.get('desc') }">
                        <label>Description</label>
                        <input type="text" name="desc" class="form-control" v-model="form.desc"/>
                        <span class="help-block" v-if="form.errors.has('desc')" v-text="form.errors.get('desc')"></span>
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
              link: '',
              imgs: '',
              desc: '',
              product_id: '',
              category_id: ''
            }),
            categories:[]
          }
        },

        created(){
          this.getCategories();

          Event.$on('edit-accessory', (accessory) => {
            this.editing = 1;
            this.form.reset();
            this.form.load(accessory);
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
              this.form.post('/admin/accessories')
                .then(data => {
                  this.refreshList();
                  this.notify('Accessories management',data.message,'success');
                })
                .catch(errors =>{
                  this.notify('Accessories management',errors.message,'warn');
                });
            }else{
              this.form.put('/admin/accessories')
                .then(data => {
                  this.refreshList();
                  this.notify('Accessories management',data.message,'success');
                })
                .catch(errors => {
                  this.notify('Accessories management',errors.message,'warn');
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
