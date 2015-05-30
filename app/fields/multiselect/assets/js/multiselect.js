(function($) {


  var Multiselect = function(element) {

    var self = this;

    // basic elements and stuff
    this.sortmode    = 'order';
    this.multiselect = $(element);
    this.field       = this.multiselect.parent().parent();
    this.list        = this.multiselect.next();
    this.checkboxes  = this.list.find('input[type="checkbox"]');
    this.gap         = this.multiselect.find('.placeholder');
    this.label       = this.field.find('.label');
    this.elements    = [];
    this.readonly    = this.multiselect.data('readonly');

    this.add = function(item) {
      var index    = item.parent().parent().index();
      var key      = item.val();
      var value    = item.parent().text();
      self.elements.push({order: index, name: key, value: value});
    };

    this.remove = function(item) {
      var key = item.val();
      self.multiselect.find('span[title="' + key + '"]').remove();
      self.elements = $.grep(self.elements, function(v) {
        return v.name != key;
      });
    }

    this.sort = function(mode) {
      self.elements.sort(function(a, b) {
        if(mode=='alpha') {
          var x = a.name.toLowerCase();
          var y = b.name.toLowerCase();
          return x.localeCompare(y);
        } else if(mode=='order') {
          return a.order - b.order;
        }
      });
    };

    this.read = function() {
      self.checkboxes.filter(':checked').each(function() {
        self.add($(this));
      })
      self.fill();
    };

    this.fill = function () {
      self.sort(self.sortmode);
      self.clear();
      $.each(self.elements, function(i, v) {
        var html  = '<span class="item" title="' + v.name + '">' + v.value + '</span>';
        self.multiselect.append(html);
      });
      self.placeholder();
    };

    this.clear = function () {
      self.multiselect.find('.item').remove();
    };

    this.placeholder = function () {
      if(self.elements.length > 0) {
        self.gap.hide();
      } else {
        self.gap.show();
      }
    };

    this.enableSelect = function() {
      self.multiselect.add(self.label).on('click', function () {
        self.list.toggle();
        self.multiselect.toggleClass('input-is-focused');
      });

      $(document).bind('click', function (e) {
        var target = $(e.target);
        if(!self.field.has(target).length) {
          self.list.hide();
          self.multiselect.removeClass('input-is-focused');
        }
      });
    };

    this.onCheck = function() {
      self.checkboxes.on('change', function () {
        var checkbox = $(this);
        if (checkbox.is(':checked')) {
          self.add(checkbox);
        } else {
          self.remove(checkbox);
        }
        self.fill();
      });
    };

    this.init = function () {
      self.read();

      if(!self.readonly) {
        self.enableSelect();
        self.onCheck();
      }
    };

    // start the plugin
    return this.init();

  };

  // jquery helper for the multiselect plugin
  $.fn.multiselect = function() {

    return this.each(function() {

      if($(this).data('multiselect')) {
        return $(this).data('multiselect');
      } else {
        var multiselect = new Multiselect(this);
        $(this).data('multiselect', multiselect);
        return multiselect;
      }

    });

  };

})(jQuery);
