username:
  label: users.form.username.label
  type:  text
  icon: user
  readonly: true
  help: users.form.username.readonly
firstName:
  label: users.form.firstname.label
  type: text
  width: 1/2
  autofocus: true
lastName:
  label: users.form.lastname.label
  type: text
  width: 1/2
email:
  label: users.form.email.label
  type: email
  required: true
password:
  label: users.form.password.new.label
  type: password
  help: users.form.password.new.help
  width: 1/2
  help: >
    <code class="pw-suggestion"></code><a class="pw-reload" href="#"><i class="fa fa-refresh icon"></i></a>
passwordConfirmation:
  label: users.form.password.new.confirm.label
  type: password
  help: &nbsp;
  width: 1/2
language:
  label: users.form.language.label
  type: select
  required: true
  width: 1/2
role:
  label: users.form.role.label
  type: select
  required: true
  width: 1/2
