var app = app || {};

(function () {
	'use strict';

	app.TodoModel = function () {
		this.onChanges = [];
    var _this = this;

    $.ajax({
      type: 'GET',
      dataType: 'json',
      url: '/api/v1/todo',
      success: function(data) {
        _this.todos = data;
      },
      error: function(error) {
        alert(JSON.stringify(error));
        _this.todos = [];
      }
    });
	};

	app.TodoModel.prototype.subscribe = function (onChange) {
		this.onChanges.push(onChange);
	};

	app.TodoModel.prototype.inform = function () {
		this.onChanges.forEach(function (cb) { cb(); });
	};

	app.TodoModel.prototype.add = function (subject, categories) {
    var _this = this;
    $.ajax({
      type: 'PUT',
      dataType: 'json',
      url: '/api/v1/todo',
      data: { subject: subject, categories: categories },
      success: function(data) {
        _this.todos = _this.todos.concat(data);

        _this.inform();
      },
      error: function(error) {
        alert(JSON.stringify(error));
      }
    });
	};

	app.TodoModel.prototype.delete = function (todo) {
    var _this = this;
    $.ajax({
      type: 'DELETE',
      dataType: 'json',
      url: '/api/v1/todo/' + todo.id,
      success: function() {
        _this.todos = _this.todos.filter(function (candidate) {
    			return candidate !== todo;
    		});

    		_this.inform();
      },
      error: function(error) {
        alert(JSON.stringify(error));
      }
    });
	};

	app.TodoModel.prototype.update = function (todoToSave, updates) {
    var _this = this;
    alert(JSON.stringify(Object.assign(todoToSave, updates)));
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '/api/v1/todo',
      data: Object.assign(todoToSave, updates),
      success: function(updatedTodo) {
        _this.todos = _this.todos.map(function (todo) {
    			return todo !== todoToSave ? todo : updatedTodo;
    		});

    		_this.inform();
      },
      error: function(error) {
        alert(JSON.stringify(error));
      }
    });
	};

})();
