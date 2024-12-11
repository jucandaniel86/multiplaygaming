<script setup>
import {ref, shallowRef, reactive, onMounted} from 'vue';

import {useMainStore} from "../stores/main";
import useUsers from "../composables/users";
import {mdiArrowRightBold, mdiEmailAlertOutline} from '@mdi/js';

const snackbar = ref(false);
const success = ref(false);
const message = ref('');
const loading = ref(false);
const modal = ref(false);
const form = reactive({
  subject: '',
  message: '',
});

const breadcrumbs = shallowRef([
  {
    title: 'Client Area',
    disabled: false,
    to: {name: 'ca.index'}
  },
  {
    title: 'Support',
    disabled: true,
    href: '#'
  },
]);
const {sendSupport, getUser, user, userLoading} = useUsers();
const mainStore = useMainStore();
mainStore.SET_BREADCRUMBS(breadcrumbs);

const sendRequest = async () => {
  loading.value = true;
  const data = await sendSupport(form);

  success.value = data.success;
  if (!data.success) {
    message.value = "Something went wrong. Please try again";
    snackbar.value = true;
  } else {
    message.value = data.message;
    snackbar.value = true;
    modal.value = false;
  }
  loading.value = false;
}

onMounted(getUser);

</script>
<template>
  <v-snackbar
    v-model="snackbar"
    :color="success ? 'green' : 'red'"
    :timeout="3000"
    position="sticky"
    location="top">
    {{ message }}
  </v-snackbar>
  <v-progress-linear indeterminate v-if="userLoading" color="primary"/>
  <v-row v-if="!userLoading && user">
    <v-col cols="12" md="12">
      <div class="d-flex align-center ga-2 mb-4">
        <v-icon :icon="mdiArrowRightBold" color="primary"/>
        <span class="font-weight-bold text-h5">Support</span>
      </div>
      <p>
        Dear {{ user.name }}, <br/><br/>

        If you encounter any issues with our products, need a new Client Hub account, or want more information about a
        specific game, please reach out to us at support@bluejackgaming.com. We’re here to assist and will respond as
        quickly as possible. <br/><br/>

        Thank you!<br/>
        The Bluejack Gaming Support Team
      </p>
      <v-btn color="primary" class="mt-2" @click="modal = true">Contact</v-btn>
    </v-col>
  </v-row>
  <v-dialog v-model="modal" max-width="500" height="auto" z-index="99999">
    <v-card :title="'Support'" color="white">
      <v-card-text>
        <v-select
          :items="['Business', 'Streamers', 'Affiliates', 'HR/Marketing', 'Support', 'Career', 'Other']"
          :item-value="'id'"
          :item-title="'label'"
          label="Subject"
          color="primary"
          v-model="form.subject"
        />
        <v-textarea
          label="Message"
          color="primary"
          clear-icon="mdi-close-circle"
          clearable
          rows="5"
          v-model="form.message"
        ></v-textarea>
      </v-card-text>
      <v-card-actions>
        <v-btn
          @click.prevent="sendRequest"
          color="primary"
          :disabled="loading">
          Submit
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
