<template>
  <div>
    <notifications group="categories" />
    <part-modal id="modal-form">
      <h4 class="modal-title" slot="title">{{ editing ? 'Edit category' : 'Add new category'}}</h4>
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
              code: '',
              desc: '',
              order: ''
            })
          }
        },

        created(){
          Event.$on('edit-category', (category) => {
            this.editing = 1;
            this.form.reset();
            this.form.load(category);
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
              this.form.post('/admin/categories')
                .then(data => {
                  this.refreshList();
                  this.notify('Categories management',data.message,'success');
                })
                .catch(errors =>{
                  this.notify('Categories management',errors.message,'warn');
                });
            }else{
              this.form.put('/admin/categories')
                .then(data => {
                  this.refreshList();
                  this.notify('Categories management',data.message,'success');
                })
                .catch(errors => {
                  this.notify('Categories management',errors.message,'warn');
                });
            }

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
            $('.modal-backdrop').remove()
          }

        }
    }



</script>
