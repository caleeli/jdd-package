<template>
  <panel name="Test Component" icon="fa fa-user" class="panel-success">
    <div class="m-t">
      <button
        type="submit"
        class="btn btn-primary block full-width m-b"
        @click="callProcess('test.bpmn')"
      >Start Test Process</button>
      <grid v-model="records">
        <template slot="header">
          <th>id</th>
          <th>data</th>
          <th>status</th>
        </template>
        <template v-slot="{row}">
          <td>{{row.id}}</td>
          <td>{{row.attributes.data}}</td>
          <td>{{row.attributes.status}}</td>
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
      records: this.axiosList("test"),
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
