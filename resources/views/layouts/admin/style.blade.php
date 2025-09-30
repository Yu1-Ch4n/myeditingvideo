<style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
        font-feature-settings: "cv03", "cv04", "cv11";
        font-family: var(--tblr-font-sans-serif);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .note-editable ul {
        list-style-type: initial !important;
        padding-left: 20px !important;
    }

    .note-editable ol {
        list-style-type: decimal !important;
        padding-left: 20px !important;
    }
</style>

@stack('styles')
