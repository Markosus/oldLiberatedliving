jQuery(function($) {
  function zcInit() {
    var client = new ZeroClipboard($('.btn-copy'));
    
    client.on('ready', function(event) {
      client.on('copy', function(event) {
        var $prevEle = $(event.target).prev();
        var text = $prevEle.is('textarea') ? $prevEle.val().replace(/\n/g, '\r\n') : $prevEle.val();

        if (text) {
          event.clipboardData.setData('text/plain', text);
        }
      });
    
      client.on('aftercopy', function(event) {
        if (event.data['text/plain']) {
          $(event.target).next().finish().fadeIn(30).fadeOut(1000);
        }
      });
    });
    
    client.on('error', function(event) {
      ZeroClipboard.destroy();
    });
  }

  function addHandler_WinClipData() {
    $('.btn-copy').click(function() {
      var $prevEle = $(this).prev();
      var text = $prevEle.is('textarea') ? $prevEle.val().replace(/\n/g, '\r\n') : $prevEle.val();

      if (text && window.clipboardData.setData('Text', text)) {
        $(this).next().finish().fadeIn(30).fadeOut(1000);
      }
    });
  }

  function addHandler_AlertMsg() {
    $('.btn-copy').click(function() {
      if ($(this).prev().val()) {
        alert('No Flash installed. Please copy manually');
        $(this).prev().focus().select();
      }
    });
  }

  function detectFlash() {
    var hasFlash = false, obj, types, type;
    try {
      obj = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
      if (obj) {
        hasFlash = true;
      }
    } catch(e) {
      types = navigator.mimeTypes;
      type = 'application/x-shockwave-flash';
      if (types && types[type] && types[type].enabledPlugin) {
        hasFlash = true;
      }
    }
    return hasFlash;
  }

  var hasWinClipData = !!(window.clipboardData && clipboardData.setData),
    hasFlash = detectFlash();

  if (hasWinClipData) {
    addHandler_WinClipData();
  } else if (hasFlash) {
    $.ajax({
      type: 'GET',
      url: 'http://cdnjs.cloudflare.com/ajax/libs/zeroclipboard/2.2.0/ZeroClipboard.min.js',
      dataType: 'script',
      cache: true,
      success: zcInit,
      error: addHandler_AlertMsg
    });
  } else {
    addHandler_AlertMsg();
  }
});