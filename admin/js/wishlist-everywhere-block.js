const { registerBlockType } = wp.blocks;

registerBlockType('wishlist-everywhere/wishlist-block', {
    title:'Wishlist Page',
    icon:'heart',
    category: 'widgets',

    edit(){
        return(
            wp.element.createElement(
                'p',
                null,
                'Wishlist Page will appear here on the frontend.'
            )
        );
    },

    // Because it's dynamic, we don't save markup to post content
    save() {
        return null;
    }
})