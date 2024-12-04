jQuery(document).ready(function($) {
  $('.ai-deny-toggle').on('change', function() {
    const $toggle = $(this);
    const bot = $toggle.data('bot');
    const enabled = $toggle.prop('checked');

    $.ajax({
      url: ai_deny.ajaxUrl,
      type: 'POST',
      data: {
        action: 'update_robots_rule',
        nonce: ai_deny.nonce,
        bot: bot,
        enabled: enabled
      },
      success: function(response) {
        if (!response.success) {
          alert('Failed to update setting');
          $toggle.prop('checked', !enabled);
        }
      },
      error: function() {
        alert('Failed to update setting');
        $toggle.prop('checked', !enabled);
      }
    });
  });
});