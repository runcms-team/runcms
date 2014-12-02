<?php

// The name of this module
define("_MI_NSECTIONS_NAME", "Tutorials");

define("_MI_NSECTIONS_CONFIG", "Main Configuration");

// A brief description of this module
define("_MI_NSECTIONS_DESC", "Creates a section where admins can post various articles.");

// Names of blocks for this module (Not all module has blocks)
define("_MI_NSECTIONS_BNAME1", "Popular Section Articles");
define("_MI_NSECTIONS_POP", "Show popular section articles");

define("_MI_NSECTIONS_BNAME2", "Recent Section Articles");
define("_MI_NSECTIONS_REC", "Show recent section articles");


// ------------------------------------------------------------------//
// Configure directory name & DB tables
// Has nothing to do with language config! This is a hack/workaround!
// No need to add the actual DB prefix
define("_MI_NSECTIONS_TABLE", "nsections");
define("_MI_NSECCONT_TABLE", "nseccont");
define("_MI_DIR_NAME", "sections");
?>
