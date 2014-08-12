(function($) {

  var Structure = function(element) {

    var self = this;

    this.element   = $(element);
    this.list      = $('<div class="structure-entries"></div>');
    this.input     = this.element.find('input[type=hidden]');
    this.page      = this.element.data('page');
    this.button    = this.element.find('.structure-add-button');
    this.json      = this.input.val() ? $.parseJSON(this.input.val()) : [];
    this.entries   = [];
    this.template  = Handlebars.compile(this.element.find('.structure-entries-template').html());

    this.render = function() {

      self.list.html(self.template({
        entries: self.entries
      }));

      self.list.find('.structure-add-button').on('click', function() {
        self.button.trigger('click');
        return false;
      });

      self.list.find('.structure-delete-button').on('click', function() {
        self.remove($(this).data('structure-id'));
        return false;
      });

      self.list.find('.structure-edit-button').on('click', function() {
        self.edit($(this).data('structure-id'));
        return false;
      });

      if(self.element.data('sortable') == true && self.list.find('.structure-entry').length > 1) {

        self.list.sortable({
          update: function() {

            var result = [];

            $.each($(this).sortable('toArray'), function(i, id) {

              var id = id.replace('structure-entry-', '');

              $.each(self.entries, function(i, entry) {
                if(entry._id == id) {
                  result.push(entry);
                }
              });

            });

            self.entries = result;
            self.serialize();

          }
        });

      }

      self.list.disableSelection();
      self.serialize();

    };

    this.serialize = function() {
      self.input.val(JSON.stringify(self.entries));
    };

    this.id = function() {
      return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    };

    this.form = function(input, mode) {
      app.popup.form('editor/structure/' + self.page + '/' + self.input.attr('name'), input, null, function(form, data) {
        mode == 'add' ? self.add(data) : self.update(input._id, data);
        app.popup.hide();
      });
    };

    this.add = function(data) {
      data._id = self.id();
      self.entries.push(data);
      self.render();
    };

    this.edit = function(id) {

      var data = $.grep(self.entries, function(item) {
        return item._id == id;
      })[0];

      self.form(data, 'edit');

    };

    this.update = function(id, data) {

      data._id = id;

      $.each(self.entries, function(i, item) {
        if(item._id != id) return;
        self.entries[i] = data;
      });

      self.render();

    };

    this.remove = function(id) {

      if(confirm('Do you really want to delete this entry?')) {
        self.entries = $.grep(self.entries, function(item) {
          return item._id != id;
        });
        self.render();
      }

    };

    this.init = function() {

      self.element.append(self.list);

      self.button.on('click', function() {
        self.form({}, 'add');
        return false;
      });

      $.each(self.json, function(i, item) {
        item['_id'] = self.id();
        self.entries.push(item);
      });

      self.render();

    };

    return this.init();

  };

  $.fn.structure = function() {

    return this.each(function() {

      if($(this).data('structure')) {
        return $(this).data('structure');
      } else {
        var structure = new Structure(this);
        $(this).data('structure', structure);
        return structure;
      }

    });

  };

})(jQuery);