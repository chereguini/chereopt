wp.domReady(() => {
    wp.data.subscribe(() => {
        const selectedBlock = wp.data.select('core/block-editor').getSelectedBlock();
        if (selectedBlock && selectedBlock.name === 'core/gallery' && !selectedBlock.attributes.linkTo) {
            wp.data.dispatch('core/block-editor').updateBlockAttributes(selectedBlock.clientId, { linkTo: 'media' });
        }
    });
});