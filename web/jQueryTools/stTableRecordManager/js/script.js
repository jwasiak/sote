jQuery(function($)
{
   $.fn.stTableRecordManager = function(options)
   {
      var subject = $(this);

      var body = subject.find('tbody');

      subject.find('.template .actions .create').click(add);

      subject.find('.template input, .template select, .template textarea').keypress(function(event) {
         return event.keyCode != 13;
      }).keyup(function(event) {
         if (event.keyCode == 13)
         {
            return add(event);
         }

         return true;
      });

      subject.find('.tbody .actions .remove').click(remove);

      body.find('td.actions a').click(actionDispatcher);

      var index = body.children().size();

      function add(event)
      {
         var row = $('<tr></tr>');

         var fields = {};

         subject.find('.template th').each(function() {
            current = $(this);

            var td = $('<td></td>');

            td.attr('class', current.attr('class'));

            if (current.hasClass('actions'))
            {
               current.find('a').each(function(){
                  if (!$(this).hasClass('create'))
                  {
                     $(this).clone().click(actionDispatcher).appendTo(td);
                  }
               });
            }
            else
            {
               current.find('input, select, textarea').each(function() {
                  var current = $(this);

                  var field = current.clone();

                  field.attr('name', options.namespace + '[' + index + '][' + current.attr('name')  + ']');

                  field.attr('id', field.attr('name').replace(/\[/g, '_').replace(/\]/g, ''));

                  // clone issue workaround
                  if (current.is('select'))
                  {
                     field.val(current.val());
                  }

                  field.attr('prev-name', current.attr('name'));

                  field.appendTo(td);

                  fields[current.attr('name')] = field.get(0);

               });
            }

            td.appendTo(row);
         });

         row.appendTo(body);

         index++;

         highlight(row);

         subject.find('.template th input, .template th select, .template th textarea').each(function() {
            if (this.type == 'select-one')
            {
               $(this).children().each(function() {
                  this.selected = this.defaultSelected;
               });
            }
            else if (this.type == 'hidden')
            {
               this.value = '';
            }
            else
            {
               this.value = this.defaultValue;
            }
         });

         subject.trigger('postAdd', [row, fields]);

         return false;
      }

      function remove(event, target)
      {
         if (window.confirm(options.confirmMsg ? options.confirmMsg : 'Are you sure?'))
         {
            var parent = target.parents('tr');

            subject.trigger('preRemove', [parent]);

            parent.remove();

            subject.trigger('postRemove');
         }
         
         return false;
      }

      function actionDispatcher(event)
      {
         var current = $(this);

         if (current.hasClass('remove'))
         {
            return remove(event, current);
         }

         return true;
      }

      function highlight(target)
      {
        $(target).css('background-color', '#ffff99');
        $(target).animate({backgroundColor: '#ffffff'}, 800);
      }
   }
});