{"version":3,"sources":["script.js"],"names":["window","BX","namespace","Sender","Letter","Page","Helper","this","context","prototype","init","params","containerId","actionUri","isFrame","prettyDateFormat","isSaved","isOutside","mess","letterTile","templateChangeButton","selectorNode","getNode","editorNode","titleNode","buttonsNode","templateNameNode","templateTypeNode","templateIdNode","Template","Selector","selector","addCustomEvent","events","templateSelect","onTemplateSelect","bind","selectorClose","closeTemplateSelector","showTemplateSelector","titleEditor","dataNode","disabled","isTemplateShowed","defaultTitle","getPatternTitle","name","initButtons","top","onCustomEvent","slider","close","UI","Notification","Center","notify","content","outsideSaveSuccess","autoHideDelay","replace","patternTitle","date","format","template","textContent","value","type","code","dispatch","getNodes","forEach","node","getAttribute","fireEvent","scrollTo","changeDisplayingTemplateSelector","isShow","classShow","classHide","changeClass","changeDisplay","disable","enable"],"mappings":"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","file":""}