<template>
  <div>
    <notifications group="options" />
    <part-modal id="modal-form">
      <h4 class="modal-title" slot="title">{{ editing ? 'Edit serie' : 'Add new serie'}}</h4>
      <div  slot="body">
        <form v-on:submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)" >
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
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div v-bind:class="{ 'has-error': form.errors.get('order') }">
                        <label>Order</label>
                        <input type="text" name="order" class="form-control" v-model="form.order" />
                        <span class="help-block" v-if="form.errors.has('order')" v-text="form.errors.get('order')"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div v-bind:class="{ 'has-error': form.errors.get('optiongroup_id') }">
                        <label>Option group</label>
                        <select class="form-control" name="optiongroup_id" v-model="form.optiongroup_id"  @change="form.errors.clear('optiongroup_id')">
                              <option v-for="optiongroup in optiongroups" v-bind:value="optiongroup.id"> {{ optiongroup.name }}</option>
                        </select>
                        <!-- <input type="text" name="optiongroup_id" class="form-control" v-model="form.optiongroup_id"/> -->
                        <span class="help-block" v-if="form.errors.has('optiongroup_id')" v-text="form.errors.get('optiongroup_id')"></span>
                    </div>
                </div>
            </div>
            <div class="row"><br>
                <div class="col-md-4">

                </div>
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
              order: '',
              desc: '',
              optiongroup_id: ''
            }),
            optiongroups:[]
          }
        },

        created(){
          this.getOptiongroups();

          Event.$on('edit-option', (option) => {
            this.editing = 1;
            this.form.reset();
            this.form.load(option);
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
              this.form.post('/admin/options')
                .then(data => {
                  this.refreshList();
                  this.notify('Options management',data.message,'success');
                })
                .catch(errors =>{
                  this.notify('Options management',errors.message,'warn');
                });
            }else{
              this.form.put('/admin/options')
                .then(data => {
                  this.refreshList();
                  this.notify('Options management',data.message,'success');
                })
                .catch(errors => {
                  this.notify('Options management',errors.message,'warn');
                });
            }

          },

          getOptiongroups(){
            axios.get('/admin/optiongroups')
                .then(response => {
                    this.optiongroups = response.data;
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
          },

          myFunction(){
            console.log('ok');
          }

        }
    }



</script>
