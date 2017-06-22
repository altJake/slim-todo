var app = app || {};

(function () {
	'use strict';

	app.CategoryModel = function () {
		this.onChanges = [];
    var _this = this;

    $.ajax({
      type: 'GET',
      dataType: 'json',
      url: '/api/v1/category',
      success: function(data) {
        _this.categories = data;
      },
      error: function(error) {
        alert(JSON.stringify(error));
        _this.categories = [];
      }
    });
	};

	app.CategoryModel.prototype.subscribe = function (onChange) {
		this.onChanges.push(onChange);
	};

	app.CategoryModel.prototype.inform = function () {
		this.onChanges.forEach(function (cb) { cb(); });
	};

	app.CategoryModel.prototype.add = function (name) {
    var _this = this;
    $.ajax({
      type: 'PUT',
      dataType: 'json',
      url: '/api/v1/category',
      data: { name: name },
      success: function(data) {
        _this.categories = _this.categories.concat(data);

        _this.inform();
      },
      error: function(error) {
        alert(JSON.stringify(error));
      }
    });
	};

	app.CategoryModel.prototype.delete = function (category) {
    var _this = this;
    $.ajax({
      type: 'DELETE',
      dataType: 'json',
      url: '/api/v1/category/' + category.id,
      success: function() {
        _this.categories = _this.categories.filter(function (candidate) {
    			return candidate !== category;
    		});

    		_this.inform();
      },
      error: function(error) {
        alert(JSON.stringify(error));
      }
    });
	};

	app.CategoryModel.prototype.update = function (categoryToSave, text) {
    var _this = this;
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: '/api/v1/category',
      data: Object.assign(categoryToSave, { name: text }),
      success: function() {
        _this.categories = _this.categories.map(function (category) {
    			return category !== categoryToSave ? category : Object.assign({}, category, {name: text});
    		});

    		_this.inform();
      },
      error: function(error) {
        alert(JSON.stringify(error));
      }
    });
	};

})();
