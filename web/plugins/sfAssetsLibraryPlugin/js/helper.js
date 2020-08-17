function stAssetsLibraryHelper() {}

stAssetsLibraryHelper.fixFilename = function(filename, strip_ext)
{   
   if (strip_ext)
   {
      var dot = filename.lastIndexOf(".");

      if (dot != -1)
      {
         filename = filename.substr(0, dot);
      }
   }

   filename = filename.replace(/[^a-z0-9]/gi, '-');

   filename = filename.replace(/[-]+/gi, '-');

   if (filename[0] == '-')
   {
      filename = filename.slice(1);
   }

   if (filename[filename.length-1] == '-')
   {
      filename = filename.slice(0, filename.length-1);
   }

   return filename;
}

stAssetsLibraryHelper.extractExtension = function(filename)
{
   var dot = filename.lastIndexOf(".");

   var ext = '';

   if (dot != -1)
   {
      ext = filename.substr(dot + 1);
   }

   return ext;
}