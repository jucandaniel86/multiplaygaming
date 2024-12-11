import Vue from "vue";

export default function ({ $auth }) {
  function hasPermission(binding) {
    if (!binding) return true;
    return !hasNotPermission(binding);
  }

  function usePermission() {
    if (!$auth.user.permissions) return [];
    return $auth.user.permissions.map((el) => el.name);
  }

  function hasNotPermission(binding) {
    if (!binding) return true;
    const activePermissions = typeof binding === "string" ? [binding] : binding;

    return !activePermissions.some((permission) =>
      usePermission().includes(permission)
    );
  }

  Vue.directive("can", {
    inserted(el, binding, vnode) {
      if (binding.arg === "not") {
        if (hasPermission(binding.value)) {
          el.remove();
        }
        return;
      }
      if (!hasPermission(binding.value)) {
        console.log(vnode.elm);
        vnode.elm.remove();
      }
    },
  });
}
