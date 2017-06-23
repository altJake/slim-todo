import $ from 'jquery';

export class CategoryModel {
	constructor() {
		this.modelUri = '/api/v1/category/';
		this.onChanges = [];
		this.categories = [];

		this.get();
	}

	subscribe(onChange) {
		this.onChanges.push(onChange)
	}

	inform() {
		this.onChanges.forEach(function (cb) { cb(); });
	}

	get() {
		$.ajax({
      type: 'GET',
      dataType: 'json',
      url: this.modelUri,
      success: (data) => this.categories = data,
      error: (error) => alert(JSON.stringify(error))
    });
	}

	add(name) {
		$.ajax({
      type: 'PUT',
      dataType: 'json',
      url: this.modelUri,
      data: { name: name },
      success: (data) => {
        this.categories = this.categories.concat(data);
        this.inform();
      },
      error: (error) => alert(JSON.stringify(error))
    });
	}

	update(categoryToUpdate, updates) {
		$.ajax({
      type: 'POST',
      dataType: 'json',
      url: this.modelUri,
      data: Object.assign(categoryToUpdate, updates),
      success: (data) => {
        this.categories = this.categories.map((category) => {
    			return category !== categoryToUpdate ? category : data;
    		});

    		this.inform();
      },
      error: (error) => alert(JSON.stringify(error))
    });
	}

	delete(category) {
    $.ajax({
      type: 'DELETE',
      dataType: 'json',
      url: this.modelUri + category.id,
      success: () => {
        this.categories = this.categories.filter((candidate) => {
    			return candidate !== category;
    		});

    		this.inform();
      },
			error: (error) => alert(JSON.stringify(error))
    });
	}
}
