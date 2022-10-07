describe('Bookmarks management', () => {
    before(() => {
        cy.request('/dataReset/dbReset');
    });

    it('shows bookmarks', () => {
        cy.userConnect();

        cy.url().should('contain', '/bookmarks')
        cy.get('table tbody tr').should('have.length', 5);
        cy.contains('LetsEncrypt').parent('tr').contains('View').click();

        cy.url().should('contain', '/bookmarks/view/')
        cy.contains('https://letsencrypt.org');
        cy.contains('Free open Certificate Authority');
    })

    it('modifies a bookmark', () => {
        cy.userConnect();

        cy.url().should('contain', '/bookmarks')
        cy.contains('LetsEncrypt').parent('tr').contains('Edit').click();

        cy.url().should('contain', '/bookmarks/edit/')
        cy.get('input[name="title"]').type(" goood");
        cy.get('input[name="description"]').type(" Some more content.");
        cy.get('button[type="submit"]').click();

        cy.url().should('contain', '/bookmarks')
        cy.contains('The bookmark has been saved.');
        cy.contains('LetsEncrypt goood');
    })
})
