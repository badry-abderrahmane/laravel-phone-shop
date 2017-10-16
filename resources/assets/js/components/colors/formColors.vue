<template>
  <div>
    <notifications group="colors" />
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
                  <div v-bind:class="{ 'has-error': form.errors.get('code') }">
                      <label>Code</label>
                      <input type="text" name="code" class="form-control" v-model="form.code"/>
                      <span class="help-block" v-if="form.errors.has('code')" v-text="form.errors.get('code')"></span>
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
              code:'',
            }),
          }
        },

        created(){
          Event.$on('edit-color', (color) => {
            this.form.load(color);
            $('#modal-form').modal('show');
          });

          Event.$on('reset-form', () => {
            this.form.reset();
          });
        },

        methods: {

          onSubmit(){
            if (this.form.id == '') {
              this.form.post('/admin/colors')
                .then(data => {
                  this.refreshList();
                  this.notify('Colors management',data.message,'success');
                })
                .catch(errors =>{
                  this.notify('Colors management',errors.message,'warn');
                });
            }else{
              this.form.put('/admin/colors')
                .then(data => {
                  this.refreshList();
                  this.notify('Colors management',data.message,'success');
                })
                .catch(errors => {
                  this.notify('Colors management',errors.message,'warn');
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
            $('.modal-backdrop').attr('class','');
          }

        }
    }



</script>
