import React from 'react';
import classnames from 'classnames';

var ESCAPE_KEY = 27;
var ENTER_KEY = 13;

export class TodoItem extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      editSubject: this.props.todo.subject
    }
  }

  handleEdit() {
    this.props.onEdit();
    this.setState({ editSubject: this.props.todo.subject });
  }

  handleChange(event) {
    if (this.props.editing) {
      this.setState({ editSubject: event.target.value });
    }
  }

  handleSubmit(event) {
    var val = this.state.editSubject.trim();
    if (val) {
      this.props.onSave(val);
      this.setState({ editSubject: val });
    } else {
      this.props.onDelete();
    }
  }

  handleKeyDown(event) {
    if (event.which === ESCAPE_KEY) {
      this.setState({ editSubject: this.props.todo.subject });
      this.props.onCancel(event);
    } else if (event.which === ENTER_KEY) {
      this.handleSubmit(event);
    }
  }

  componentDidUpdate(prevProps) {
    if (!prevProps.editing && this.props.editing) {
      var node = this.refs.editField;
      node.focus();
      node.setSelectionRange(node.value.length, node.value.length);
    }
  }

  render() {

    var todoCategories =
      <section className="categories-holder" onDoubleClick={this.handleEdit.bind(this)}>
      </section>;

    if (this.props.todo.categories.length) {
      var items = this.props.todo.categories.map(category =>
        <div key={category.id} className="category-item" onDoubleClick={this.handleEdit.bind(this)}>{category.name}</div>
      );

      var todoCategories =
        <section className="categories-holder" onDoubleClick={this.handleEdit.bind(this)}>
          {items}
        </section>;
    }

    return (
      <li className={classnames({
        'is-done': this.props.todo.isDone,
        'is-editing': this.props.editing
      })}>
        <div className="view">
          <input
            className="toggle"
            type="checkbox"
            checked={this.props.todo.isDone}
            onChange={this.props.onToggle}
          />
          <label onDoubleClick={this.handleEdit.bind(this)}>
            {this.props.todo.subject}
          </label>
          {todoCategories}
          <button className="delete-todo" onClick={this.props.onDelete} />
        </div>
        <input
          ref="editField"
          className="edit"
          value={this.state.editSubject}
          onBlur={this.handleSubmit.bind(this)}
          onChange={this.handleChange.bind(this)}
          onKeyDown={this.handleKeyDown.bind(this)}
        />
      </li>
    );
  }
}
