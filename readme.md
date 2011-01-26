NewsPublisher Extra for MODx Revolution
=======================================

**Original Author:** Raymond Irving
**Revolution Author:** Bob Ray [Bob's Guides](http://bobsguides.com)


This is a Beta version, so be aware that there may be unfound
bugs lurking in the code. It is not recommended that you install
this version on a live site until you have fully tested it.

Documentation is available at [Bob's Guides] (http://bobsguides.com/newspublisher-tutorial.html)

NewsPublisher is based on the NewsPublisher snippet for MODx
Evolution but has been completely refactored from the ground up for
MODx Revolution. When finished, it will include rich text editing
for the content and summary (introtext) fields and also for any
rich text TVs.

The rich text editing function does not work with the current version
of TinyMCE, but should (hopefully) work with future releases.

Here's a fix for the TinyMCE problem (Thanks to Bruno17!):

Change line 170 of /assets/components/tinymce/tiny.js from this:

        Ext.getCmp('modx-panel-resource').markDirty();


To this:

        var pr = Ext.getCmp('modx-panel-resource');
        if (pr) pr.markDirty();
