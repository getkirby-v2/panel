var base = 'http://sandbox.getkirby.com/panel';

describe('GetKirby [001]', function(){
  beforeEach(function(){
    cy.visit(base)
  })

  it('can load the login page [002]', function(){
    cy.contains('Login')
  })

  it('can login [003]', function(){
    cy
      .get('#form-field-username').type('bastian')
      .get('#form-field-password').type('test').type('{enter}')
      .get('header').contains('Dashboard')
  })
})

describe('Logged In User [005]', function(){

  beforeEach(function(){
    cy
      .login()
      .visit(base)
  })

  context('Working menu', function(){

    it('can open and close the main menu [00c]', function() {
      cy
        .get('#menu-toggle')
        .click()
        .get('#menu', {visible: true})
        .get('.topbar')
        .click()
        .get('#menu', {visible: false})
    })

    it('can navigate to all menu sections', function() {

      cy
        // open the dashboard
        .get('#menu-toggle')
        .click()
        .get('#menu li:first-child')
        .click()
        .get('#menu', {visible: false})

        // open site options
        .get('#menu-toggle')
        .click()
        .get('#menu li:nth-child(2)')
        .click()
        .get('.sidebar')
        .contains('Kirby info')

        // open users
        .get('#menu-toggle')
        .click()
        .get('#menu li:nth-child(3)')
        .click()
        .get('.main')
        .contains('All users')

        // logout
        .get('#menu-toggle')
        .click()
        .get('#menu li:nth-child(4)')
        .click()
        .location().its('pathname').should('eq', '/panel/login');

    });

  })

})

describe.only('Users Section [005]', function() {

  beforeEach(function(){
    cy.login()
  })

  it('can navigate to users', function() {
    cy.visit(base + '/users')
      .contains('Users')
  })

  it('can add new user', function() {

    cy
      .testuser()
      .visit(base + '/users')
      .get('.items.users .item')
      .its('length').should('eq', 2);

  })

  it('cannot add a second user with the same username', function() {

    cy
      .testuser()
      .visit(base + '/users')
      .get('.items.users .item')
      .its('length').should('eq', 2);

  });

  it('can delete a user', function() {

    cy
      .visit(base + '/users/testuser/edit')
      .get('[data-shortcut="#"]')
      .click()
      .get('.modal-content .btn-submit')
      .click()
      .visit(base + '/users')
      .get('.items.users .item')
      .its('length').should('eq', 1);

  });

})