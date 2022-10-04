
Cypress.Commands.add(
    "userConnect",
    (email = 'user@example.com', password = 'password') => {
        cy.visit('/users/login');
        cy.get('input[name=email]').type(email);
        cy.get('input[name=password]').type(password);
        cy.get('button').click();
        cy.url().should('contain', '/bookmarks')
    }
);
