<template>
  <panel name="Test Component" icon="fa fa-user" class="panel-success">
    <div class="m-t">
      <button
        type="submit"
        class="btn btn-primary block full-width m-b"
        @click="callProcess('test.bpmn')"
      >Start Test Process</button>
      <br><br>
      <grid v-model="records">
        <template slot="header">
          <row :widths="[30,200,80]" class="grid-header text-uppercase font-weight-bold">
            <p slot="c1">id</p>
            <p slot="c2">data</p>
            <p slot="c3">status</p>
          </row>
        </template>
        <template v-slot="{row}">
          <row :widths="[30,200,80]" class="border-bottom">
            <p slot="c1">{{row.id}}</p>
            <p slot="c2">{{row.attributes.data}}</p>
            <p slot="c3">{{row.attributes.status}}</p>
          </row>
        </template>
      </grid>
    </div>
  </panel>
</template>

<script>
export default {
  path: "/test",
  mixins: [window.workflowMixin],
  data() {
    return {
      records: this.axiosList("test")
    };
  },
  methods: {
    axiosList(url, params = {}) {
      const list = [];
      window.axios.get(url, params).then(response => {
        list.splice(0);
        list.push(...response.data.data);
      });
      return list;
    }
  }
};
</script>
