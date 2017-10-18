<template>
  <div>
      <notifications group="foo" />
      <part-tooltip></part-tooltip>

      <series-form></series-form>

      <part-panel>
        <p slot="heading">Series List</p>
        <div slot="body">
          <div class="row">
            <div class="col-md-4">
            </div>
              <div class="col-md-3">
                  <button class="btn btn-success btn-block"  @click='showModal()'>
                    <i class="fa fa-plus"></i>
                    &nbsp;&nbsp;ADD NEW SERIE
                  </button>
              </div>
          </div><br>
          <div class="row">
              <div class="col-md-12">
                  <table class="table table-fixed" id="seriesTable">
                      <thead><tr>
                          <th class="col-xs-1">#ID</th>
                          <th class="col-xs-2">Name</th>
                          <th class="col-xs-1">Code</th>
                          <th class="col-xs-1">Description</th>
                          <th class="col-xs-1">Nbr products</th>
                          <th class="col-xs-1">Order</th>
                          <th class="col-xs-1">State</th>
                          <th class="col-xs-2">Date</th>
                          <th class="col-xs-2" style="text-align: center;">action</th>
                      </tr>

                      </thead>
                      <tbody>
                        <tr v-for="serie in series" v-bind:class="[serie.state ? 'success' : 'danger']">
                            <td class="col-xs-1">{{ serie.id }}</td>
                            <td class="col-xs-2">{{ serie.name }}</td>
                            <td class="col-xs-1">{{ serie.code }}</td>
                            <td class="col-xs-1">{{ serie.desc }}</td>
                            <td class="col-xs-1"><span class="label bg-blue">{{ serie.count }}</span></td>
                            <td class="col-xs-1">{{ serie.order }}</td>
                            <td class="col-xs-1">
                              <span v-bind:class="[serie.state ? 'bg-green' : 'bg-red', 'label']" v-text="serie.state ? 'Enabled' : 'Disabled'"></span>
                            </td>
                            <td class="col-xs-2">{{ serie.created_at }}</td>
                            <td class="col-xs-3" style="text-align: center;">
                                <button class="btn" @click="editSerie(serie)" data-toggle="tooltip" title="Edit serie"><i class="fa fa-icon fa-edit"></i></button>
                                <button class="btn" @click="showProductSeries(serie)" data-toggle="tooltip" title="Show products of this serie"><i class="fa fa-icon fa-list-alt"></i></button>
                                <button class="btn" @click="enableSerie(serie)" v-bind:title="[serie.state ? 'Enable serie' : 'Disable serie']"  data-toggle="tooltip">
                                  <i v-bind:class="[serie.state ? 'fa-unlock' : 'fa-lock', 'fa fa-icon']"></i>
                                </button>
                                <button class="btn" @click="destroySerie(serie)" data-toggle="tooltip" title="Delete serie"><i class="fa fa-icon fa-trash"></i></button>
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
                series: [],
                dtHandle:'',
            };
        },

        created(){
            Event.$on('refresh-list', (serie) => {
                this.getSeries();
            });
        },

        mounted() {
          this.getSeries();
        },

        methods:{

            getSeries(){
                axios.get('/admin/series')
                    .then(response => {
                        this.series = response.data;
                    });
            },

            editSerie(serie){
              Event.$emit('edit-serie', serie);
            },

            enableSerie(serie){
              serie.state = !serie.state;
              axios.put('/admin/series/'+serie.id, serie)
                  .then(data => {
                    this.notify('Series management',data.message,'success');
                  })
                  .catch(errors =>{
                    this.notify('Series management',errors.message,'warn');
                  });
            },

            destroySerie(serie) {

                this.$dialog.confirm('Need your confirmation to delete serie')
                    .then(function () {
                        axios.delete('/admin/series/' + serie.id)
                            .then(response => {
                                    console.log(response.data);
                                    Event.$emit('refresh-list');
                                    this.notify('Series management','Serie well deleted.','warning');
                                },
                                (err) => {
                                    console.log("Err", err);
                                })
                            .catch(function(err){
                                console.error(err); // This will print any error that was thrown in the previous error handler.
                            });
                    })
            },
            showProductSeries(serie){
              window.location.href = '/admin/series/'+serie.id+'/edit';
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
