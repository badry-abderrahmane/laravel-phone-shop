<template>
  <div>
      <notifications group="foo" />
      <div class="row">
        <div class="col-md-4">
        </div>
          <div class="col-md-3">
              <button class="btn btn-success btn-block" @click='showModal()'>
                <i class="fa fa-plus"></i>
                &nbsp;&nbsp;ADD NEW ACCESSORY
              </button>
          </div>
      </div><br>
      <div class="row">
          <div class="col-md-12">
              <table class="table table-fixed" id="accessoriesTable">
                  <thead><tr>
                      <th class="col-xs-1">#ID</th>
                      <th class="col-xs-2">Name</th>
                      <th class="col-xs-1">Link</th>
                      <th class="col-xs-1">Images</th>
                      <th class="col-xs-1">Product</th>
                      <th class="col-xs-1">Category</th>
                      <th class="col-xs-2">Description</th>
                      <th class="col-xs-2">Date</th>
                      <th class="col-xs-2" style="text-align: center;">action</th>
                  </tr>

                  </thead>
                  <tbody>
                    <tr v-for="accessory in accessories">
                        <td class="col-xs-1">{{ accessory.id }}</td>
                        <td class="col-xs-2"><span class="label bg-gray">{{ accessory.name }}</span></td>
                        <td class="col-xs-1">{{ accessory.link }}</td>
                        <td class="col-xs-1">{{ accessory.imgs }}</td>
                        <td class="col-xs-1"><span class="label bg-green">{{ accessory.product.name }}</span></td>
                        <td class="col-xs-1"><span class="label bg-green">{{ accessory.category.name }}</span></td>
                        <td class="col-xs-2">{{ accessory.desc }}</td>
                        <td class="col-xs-2">{{ accessory.created_at }}</td>
                        <td class="col-xs-2" style="text-align: center;">
                            <button class="btn" @click="editAccessory(accessory)"><i class="fa fa-icon fa-edit"></i></button>
                            <!-- <button class="btn" @click="enableAccessory(accessory)"><i class="fa fa-icon fa-lock"></i></button> -->
                            <button class="btn" @click="destroyAccessory(accessory)"><i class="fa fa-icon fa-trash"></i></button>
                        </td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>


</template>

<script>

    export default {

        data() {
            return {
                accessories: [],
                dtHandle:'',
            };
        },

        created(){
            Event.$on('refresh-list', (accessory) => {
                this.getAccessories();
            });
        },

        mounted() {
          this.getAccessories();
        },

        methods:{

            getAccessories(){
                axios.get('/accessories')
                    .then(response => {
                        this.accessories = response.data;
                    });
            },

            editAccessory(accessory){
              Event.$emit('edit-accessory', accessory);
            },

            enableAccessory(accessory){
              accessory.state = !accessory.state;
              axios.put('/accessories/'+accessory.id, accessory)
                  .then(data => {
                    this.notify('Accessories management',data.message,'success');
                  })
                  .catch(errors =>{
                    this.notify('Accessories management',errors.message,'warn');
                  });
            },

            destroyAccessory(accessory) {

                this.$dialog.confirm('Need your confirmation to delete accessory')
                    .then(function () {
                        axios.delete('/accessories/' + accessory.id)
                            .then(response => {
                                    console.log(response.data);
                                    Event.$emit('refresh-list');
                                    this.notify('Accessories management','Accessory well deleted.','warning');
                                },
                                (err) => {
                                    console.log("Err", err);
                                })
                            .catch(function(err){
                                console.error(err); // This will print any error that was thrown in the previous error handler.
                            });
                    })
            },

            resetForm(){
              Event.$emit('reset-form');
            },
            showModal(){
              this.resetForm();
              $('#modal-form').modal('show');
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
            }
        }
    }



</script>
