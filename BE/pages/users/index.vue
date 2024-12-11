<template>
  <v-row>
    <v-col cols="12">
      <div class="bg-light rounded h-100 p-4">
        <SharedPageHeader :title="'Users'">
          <template v-slot:content>
            <button class="btn btn-primary" @click.prevent="add">
              Add new
            </button>
          </template>
        </SharedPageHeader>

        <v-data-table
          :headers="headers"
          :items="items"
          :options.sync="options"
          :server-items-length="totalItems"
          :loading="loading"
          :search="searchText"
          class="elevation-1 pa-2"
          :height="550"
        >
          <template v-slot:top>
            <div class="row">
              <div class="col-md-12">
                <v-text-field
                  v-model="searchText"
                  label="Search"
                  chips
                  class="lbl-white"
                ></v-text-field>
              </div>
            </div>
          </template>
          <template v-slot:item="{ item }">
            <tr
              :class="{
                'active-user': $auth.user && $auth.user.id === item.id,
              }"
            >
              <td class="custom-class">
                {{ item.name }} <br />
                {{ item.email }}
              </td>
              <td class="custom-class">
                <v-chip
                  small
                  color="grey"
                  v-for="role in item.roles"
                  :key="`Role_${item.id}_${role.id}`"
                  class="mb-1 mt-1"
                >
                  {{ role.name }}
                </v-chip>
              </td>
              <td class="custom-class">{{ convertDate(item.created_at) }}</td>
              <td class="custom-class">
                <button
                  type="button"
                  class="btn btn-square btn-primary m-2"
                  @click.prevent="edit(item)"
                >
                  <i class="fa fa-pencil-alt"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-square btn-primary m-2"
                  @click.prevent="openPasswordEdit(item)"
                >
                  <i class="fa fa-key"></i>
                </button>
                <button
                  type="button"
                  class="btn btn-square btn-primary text-center"
                  @click.prevent="deleteItem(item.id)"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </template>
        </v-data-table>
      </div>

      <modal
        name="form"
        :height="'auto'"
        :maxWidth="600"
        width="100%"
        :scrollable="false"
        :adaptive="true"
        :styles="{ overflow: 'visible' }"
      >
        <user-form :item="selectedItem" />
      </modal>
      <modal
        name="password"
        :height="'auto'"
        :maxWidth="600"
        width="100%"
        :scrollable="false"
        :adaptive="true"
        :styles="{ overflow: 'visible' }"
      >
        <user-password-form :item="selectedItem" />
      </modal>
    </v-col>
  </v-row>
</template>
<script>
import UserForm from "./modals/Form.vue";
import UserPasswordForm from "./modals/Password.vue";
import moment from "moment";

export default {
  name: "Users",
  layout: "backend",
  middleware: ["auth"],
  components: { UserForm, UserPasswordForm },
  data() {
    return {
      totalItems: 0,
      items: [],
      loading: true,
      searchText: "",
      searchBrand: 0,
      options: {},
      selectedItem: {},
      headers: [
        {
          text: "Name",
          align: "start",
          sortable: false,
          value: "name",
          width: "30%",
        },
        {
          text: "Roles",
          align: "start",
          sortable: false,
          value: "roles",
          width: "30%",
        },
        {
          text: "Created at",
          align: "start",
          sortable: false,
          value: "created_at",
          width: "15%",
        },
        { text: "Actions", value: "iron", width: "20%" },
      ],
    };
  },
  watch: {
    options: {
      handler() {
        this.getDataFromApi();
      },
      deep: true,
    },
    searchText() {
      if (this.searchText && this.searchText.length > 2) {
        this.getDataFromApi();
      }
      if (this.searchText.length <= 1) this.getDataFromApi();
    },
  },
  mounted() {
    //listen events
    this.$root.$on("close-modal", () => this.onModalClose());
  },
  methods: {
    add() {
      this.selectedItem = {};
      this.$modal.show("form");
    },
    edit(_item) {
      this.selectedItem = _item;
      this.$modal.show("form");
    },
    openPasswordEdit(_item) {
      this.selectedItem = _item;
      this.$modal.show("password");
    },

    convertDate: (date) => moment(date).format("MM/DD/YYYY H:mm"),

    onModalClose() {
      this.getDataFromApi();
      this.$modal.hide("form");
    },
    async getDataFromApi() {
      this.loading = true;
      try {
        const { sortBy, sortDesc, page, itemsPerPage } = this.options;

        const { data } = await this.$axios.get("/users/list", {
          params: {
            start: page,
            length: itemsPerPage,
            search: this.searchText,
          },
        });

        this.items = data.data.items;
        this.totalItems = data.total;
      } catch (err) {
        this.toastError("Something went wrong!");
      }
      this.loading = false;
    },
    async deleteItem(ID) {
      this.confirmDelete().then(async (result) => {
        if (result.value) {
          try {
            const { data } = await this.$axios.delete("/users/delete", {
              params: {
                id: ID,
              },
            });
            if (data.success) {
              this.toastSuccess(data.message);
              this.getDataFromApi();
            }
          } catch (err) {
            this.toastError("Something went wrong!");
          }
        }
      });
    },
  },
};
</script>
<style>
.text-start {
  background: transparent;
}
.active-user td {
  position: relative;
}
.active-user td:first-child::after {
  position: absolute;
  content: "Logged user";
  padding: 0.5rem;
  background: green;
  width: fit-content;
  color: #fff;
  right: 0;
  top: 0;
  height: 100%;
  display: flex;
  align-items: center;
  border-left: 3px solid #005400;
}
</style>
