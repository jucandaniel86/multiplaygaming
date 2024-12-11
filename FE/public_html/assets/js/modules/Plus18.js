const POPUP_18_PLUS_KEY = "agree_18_plus";
const OVERLAY_CLASS = ".overlay_banner18";

export const __initPlus18Popup = () => {

  const noAction = () => window.history.back();

  const yesAction = () => {
    window.localStorage.setItem(POPUP_18_PLUS_KEY, true);
    $(OVERLAY_CLASS).css('display', 'none');
  }

  if (!window.localStorage.getItem(POPUP_18_PLUS_KEY)) {
    $(OVERLAY_CLASS).css('display', 'flex');
  }

  $(OVERLAY_CLASS).find('.cancel_button').on('click', noAction);
  $(OVERLAY_CLASS).find('.confirm_button').on('click', yesAction);
}
