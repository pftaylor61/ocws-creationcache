![ocws-creationcache](./images/castlelogo80x80.png)

# ocws-creationcache
A plugin to store creationcaches (similar to "geocaches&trade;" and display them, also producing both a .gpx and .loc file for download. 

Geocache&trade; is a trademark. But there are other organizations also making these sort of caches (Opencache, EarthCache, TerraCache). Many of these contain educational geological information. I want to be able to use my own information, often interpreting things from a creationist viewpoint. However, you do not need to share my biblical and creationist beliefs to realize that an open source caching system, that can work as a plugin to a Wordpress installation, is likely to be very useful.

## Statement of the Project

Consequently, the purpose of this project is to provide such a plugin. 

* I originally thought if creating a new table for the Creation Cache information. In the end, however, I found that I could store the information I needed in the existing post-meta table. 
* The back end needed to be able to create the caches. I achieved this, by creating a new custom post type.
* I suspected that other people might not want to use the term Creation Cache. So I added a config file, to make it very easy for people to change the titles in the plugin.
* When a cache is created, a new .gpx and .loc file are created for the cache, in a special subfolder of the uploads directory.
* These files are linked for download on the Creation cache display page.
* The .gpx and .loc files are deleted, if the cache is deleted.
* I have not yet found a satisfactory way of deleting the files' subfolder in uploads, when the plugin is deleted. I notice that other plugins have this problem (Kalins PDF Creation Station, for example)
* The user admin needed some information on the use and deployment of caches, in my opinion, so I created an extensive information page, to go where the settings page normally goes. I suspect that Wordpress will not like this.
* There is also a dashboard widget, which links to the info page mentioned above
* Custom templates were created to display caches, and also cache lists (archives)

## Version 1.3
The Cache files can now be directly downloaded.

## Version 1.2
The plugin requires the Capability Manager Enhanced plugin. This feature is now included.

## Version 1.1
Some minor changes to the CPT definition, that enables role and capability editing, specifically for Creation Caches. This was so that I could add a role that is ONLY able to publish and edit creation caches - not any other post type.

Readers might be interested in the problems this upgrade gave me. I had made my 1.1 edit, and then found that the Creation caches menu disappeared from the editing screen! Yet, the creation caches were still working. I tried deleting my own plugin, and returning to 1.0, then updating again, with a newly created package. no difference!

It took ages for the obvious to hit me. I had made it so that "lower" user roles could edit and create Creation Caches. But that trick had meant that there was a Creation Cache line against the Administrator User Role, that I needed to fill in! I had to give my own Administrator role specific permissions, in order to be able to edit and Create creation Caches. Once I had done this, everything worked! The issue arose, because I am editing user role capabilities, using the Capability Manager Enhanced plugin.

## Version 1.0.1
A simple amendment, renaming the title of the archive template to 'List of...' rather than 'Archive of...'

I am aware that I need to sort out the structural css for the meta data. I am currently working on this, and will have more news soon! (12/26/2015).

## Latest Upgrade

Images are now available for the cache-type taxonomy. There is a default image, and users can upload their own images, preferable at 128 x 128.

## Future Issues

It would be useful in future to be able to upload a .gpx file, for the plugin to read it, and create a cache entry accordingly

## Plea for assistance

I am well aware that the very nature of GitHub is to encourage collaboration. I am a fairly new coder, and I should emphasize that this code is at the very edges of my knowledge. I would appreciate feedback, help and constructive criticism. Or, if you simply want to add some new functions, please be my guest! I am, after all, a very old man to be programming (54) and most of you are young enough to be my children, so I am sure your eyes are better at finding bugs than mine. Plus, I have not really got my head around object programming in PHP5, and I feel sure that my plugin would be better if it had used objects.
