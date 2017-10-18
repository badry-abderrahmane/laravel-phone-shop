<template>
  <div>
      <notifications group="foo" />
      <part-tooltip></part-tooltip>

      <colors-form></colors-form>

      <part-panel>
        <p slot="heading">Colors List</p>
        <div slot="body">
          <div class="row">
            <div class="col-md-4">
            </div>
              <div class="col-md-3">
                  <button class="btn btn-success btn-block" @click='showModal()'>
                    <i class="fa fa-plus"></i>
                    &nbsp;&nbsp;ADD NEW COLOR
                  </button>
              </div>
          </div><br>
          <div class="row">
              <div class="col-md-12">
                  <table class="table table-fixed" id="colorsTable">
                      <thead><tr>
                          <th class="col-xs-1">#ID</th>
                          <th class="col-xs-2">Name</th>
                          <th class="col-xs-1">Code</th>
                          <th class="col-xs-2">Date</th>
                          <th class="col-xs-2" style="text-align: center;">action</th>
                      </tr>

                      </thead>
                      <tbody>
                        <tr v-for="color in colors">
                            <td class="col-xs-1">{{ color.id }}</td>
                            <td class="col-xs-2"><span class="label bg-gray">{{ color.name }}</span></td>
                            <td class="col-xs-1"><span class="label bg-green">{{ color.code }}</span></td>
                            <td class="col-xs-2">{{ color.created_at }}</td>
                            <td class="col-xs-2" style="text-align: center;">
                                <button class="btn" @click="editColor(color)" data-toggle="tooltip" title="Edit color"><i class="fa fa-icon fa-edit"></i></button>
                                <!-- <button class="btn" @click="enableColor(color)"><i class="fa fa-icon fa-lock"></i></button> -->
                                <button class="btn" @click="destroyColor(color)" data-toggle="tooltip" title="Delete color"><i class="fa fa-icon fa-trash"></i></button>
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
                colors: [],
                dtHandle:'',
            };
        },

        created(){
            Event.$on('refresh-list', (color) => {
                this.getColors();
            });
        },

        mounted() {
          this.getColors();
        },

        methods:{

            getColors(){
                axios.get('/admin/colors')
                    .then(response => {
                        this.colors = response.data;
                    });
            },

            editColor(color){
              Event.$emit('edit-color', color);
            },

            enableColor(color){
              color.state = !color.state;
              axios.put('/admin/colors/'+color.id, color)
                  .then(data => {
                    this.notify('Colors management',data.message,'success');
                  })
                  .catch(errors =>{
                    this.notify('Colors management',errors.message,'warn');
                  });
            },

            destroyColor(color) {

                this.$dialog.confirm('Need your confirmation to delete color')
                    .then(function () {
                        axios.delete('/admin/colors/' + color.id)
                            .then(response => {
                                    console.log(response.data);
                                    Event.$emit('refresh-list');
                                    this.notify('Colors management','Color well deleted.','warning');
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
