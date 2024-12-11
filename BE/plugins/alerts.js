import Vue from "vue";

const DEFAULT_TOAST_OPTIONS = {
  position: "top-right",
  duration: 3500,
  onClick: () => {},
  onDismiss: () => {},
  pauseOnHover: true,
};

Vue.mixin({
  methods: {
    toastSuccess(message, options = {}) {
      let toastOptions = { ...DEFAULT_TOAST_OPTIONS, ...options };
      this.$toast.success(message, toastOptions);
    },
    toastError(message, options = {}) {
      let toastOptions = { ...DEFAULT_TOAST_OPTIONS, ...options };
      this.$toast.error(message, toastOptions);
    },
    toastInfo(message, options = {}) {
      let toastOptions = { ...DEFAULT_TOAST_OPTIONS, ...options };
      this.$toast.info(message, toastOptions);
    },
    toastWarning(message, options = {}) {
      let toastOptions = { ...DEFAULT_TOAST_OPTIONS, ...options };
      this.$toast.warning(message, toastOptions);
    },
    confirmDelete() {
      return this.$swal({
        title: "Confirm",
        text: "Are you sure you want to delete this entry?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Yes, Delete it!",
      });
    },
    confirm(text) {
      return this.$swal({
        title: "Confirm",
        text,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Yes!",
      });
    },
    alertSuccess(message) {
      this.$swal.fire("Success!!", message, "success");
    },
    alertError(message) {
      this.$swal.fire("Error!!", message, "error");
    },
    alertWarning(message) {
      this.$swal.fire("Warning!!", message, "warning");
    },
    axiosErrorAlert(_data) {
      let message = "";
      if (typeof _data.response === "undefined") {
        message = "Something went wrong!";
      } else {
        switch (_data.response.status) {
          case 500:
            message = _data.response.data.message;
            break;
          case 422:
            if (typeof _data.response.data.errors === "object") {
              message = Object.entries(_data.response.data.errors)
                .map((error) => error[1])
                .join("<br />");
            } else if (typeof _data.response.data.message !== "undefined") {
              message = _data.response.data.message;
            }

            break;
          case 403:
            message = "You don't have access!";
            break;
          case 404:
            message = "Request not found!";
            break;
          default:
            message = _data.response.data.error;
        }
      }

      this.toastError(message);
    },
  },
});
