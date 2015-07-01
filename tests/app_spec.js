describe("GetKirby [001]", function(){
  beforeEach(function(){
    cy.visit("http://sandbox.getkirby.com/panel/#/")
  })

  it("can load the login page [002]", function(){
    cy.contains("Login")
  })

  it("can login [003]", function(){
    cy
      .get("#form-field-username").type("bastian")
      .get("#form-field-password").type("test").type("{enter}")
      .get("header").contains("Dashboard")
  })
})

describe("Logged In User [005]", function(){
  beforeEach(function(){
    cy.login()
  })

  context("Adding New Page [006]", function(){
    beforeEach(function(){
      cy.get("[data-shortcut='+']").click()
    })

    it("updates url to /pages/add [007]", function(){
      cy.hash().should("eq", "#/pages/add/")
    })

    it("displays the modal [008]", function(){
      cy.get(".modal", {visible: true})
    })

    it.only("autofills url-appendix [009]", function(){
      cy
        .get("#form-field-title").type("foo")
        .get("#form-field-uid").should("have.value", "foo")
    })

    // it.only("can add a new page [00a]", function(){
    //   cy
    //     .server()
    //     .fixture("page_create").as("f")
    //     .route("POST", /create/, "@f").as("pageCreate")
    //     .route("GET", /slug/, "")
    //     .get("#form-field-title")
    //       .invoke("val", "foo" + Math.random())
    //       .invoke("trigger", "keyup")
    //     .get("#form-field-uid").invoke("val","foo" + Math.random())
    //     .get(".modal").contains("Add").click()
    //     .wait("@pageCreate")
    //     .get("#page-list").contains("")
    // })

  })
})