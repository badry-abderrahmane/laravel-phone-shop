<template>
  <div>
      <notifications group="foo" />
      <part-tooltip></part-tooltip>

      <galleries-form></galleries-form>

      <part-panel>
        <p slot="heading">Galleries List</p>
        <div slot="body">
          <div class="row">
            <div class="col-md-4">
            </div>
              <div class="col-md-3">
                  <button class="btn btn-success btn-block" @click='showModal()'>
                    <i class="fa fa-plus"></i>
                    &nbsp;&nbsp;ADD NEW GALLERY
                  </button>
              </div>
          </div><br>
          <div class="row">
              <div class="col-md-12">
                  <table class="table table-fixed" id="galleriesTable">
                      <thead><tr>
                          <th class="col-xs-1">#ID</th>
                          <th class="col-xs-2">Name</th>
                          <th class="col-xs-1">Link</th>
                          <th class="col-xs-1">Product</th>
                          <th class="col-xs-2">Description</th>
                          <th class="col-xs-1">Order</th>
                          <th class="col-xs-2">Date</th>
                          <th class="col-xs-2" style="text-align: center;">action</th>
                      </tr>

                      </thead>
                      <tbody>
                        <tr v-for="gallery in galleries">
                            <td class="col-xs-1">{{ gallery.id }}</td>
                            <td class="col-xs-2"><span class="label bg-gray">{{ gallery.name }}</span></td>
                            <td class="col-xs-1">{{ gallery.link }}</td>
                            <td class="col-xs-1"><span class="label bg-green">{{ gallery.product.name }}</span></td>
                            <td class="col-xs-2">{{ gallery.desc }}</td>
                            <td class="col-xs-1">{{ gallery.order }}</td>
                            <td class="col-xs-2">{{ gallery.created_at }}</td>
                            <td class="col-xs-2" style="text-align: center;">
                                <button class="btn" @click="editGallery(gallery)" data-toggle="tooltip" title="Edit gallery"><i class="fa fa-icon fa-edit"></i></button>
                                <!-- <button class="btn" @click="enableGallery(gallery)"><i class="fa fa-icon fa-lock"></i></button> -->
                                <button class="btn" @click="destroyGallery(gallery)" data-toggle="tooltip" title="Delete gallery"><i class="fa fa-icon fa-trash"></i></button>
                            </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
      </part-panel>

  </div>


</template>

<script>

    export default {

        data() {
            return {
                galleries: [],
                dtHandle:'',
            };
        },

        created(){
            Event.$on('refresh-list', (gallery) => {
                this.getGalleries();
            });
        },

        mounted() {
          this.getGalleries();
        },

        methods:{

            getGalleries(){
                axios.get('/admin/galleries')
                    .then(response => {
                        this.galleries = response.data;
                    });
            },

            editGallery(gallery){
              Event.$emit('edit-gallery', gallery);
            },

            enableGallery(gallery){
              gallery.state = !gallery.state;
              axios.put('/admin/galleries/'+gallery.id, gallery)
                  .then(data => {
                    this.notify('Galleries management',data.message,'success');
                  })
                  .catch(errors =>{
                    this.notify('Galleries management',errors.message,'warn');
                  });
            },

            destroyGallery(gallery) {

                this.$dialog.confirm('Need your confirmation to delete gallery')
                    .then(function () {
                        axios.delete('/admin/galleries/' + gallery.id)
                            .then(response => {
                                    console.log(response.data);
                                    Event.$emit('refresh-list');
                                    this.notify('Galleries management','Gallery well deleted.','warning');
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
