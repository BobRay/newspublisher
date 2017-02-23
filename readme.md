NewsPublisher Extra for MODX Revolution
=======================================

**Original Author:** Raymond Irving     
**Revolution Author:** Bob Ray [Bob's Guides](http://bobsguides.com)     
**Major Contributor** Markus Schlegel -Invaluable fixes, improvements, and feature additions were created and tested by Markus     
 

NewsPublisher is a front-end resource editing and creation tool for MODX Revolution.


Documentation is available at [Bob's Guides] (http://bobsguides.com/newspublisher-tutorial.html)

NewsPublisher is based on the NewsPublisher snippet for MODX
Evolution but has been completely refactored from the ground up for
MODX Revolution. It includes rich text editing
for the content and summary (introtext) fields and also for any
rich text TVs.

The rich text editing function does not work with older versions
of TinyMCE, but should work with the current release.

Here's a fix for the TinyMCE problem in older versions (Thanks to Bruno17!):

Change line 170 of /assets/components/tinymce/tiny.js from this:

        Ext.getCmp('modx-panel-resource').markDirty();


To this:

        var pr = Ext.getCmp('modx-panel-resource');
        if (pr) pr.markDirty();
