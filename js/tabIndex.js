// JavaScript Document      
      // xBroswer event subscription
      function addListener(a,b,c,d){if(a.addEventListener){a.addEventListener(b,c,d);return true;}else if(a.attachEvent){var e=a.attachEvent("on"+b,c);return e;}else{alert("Handler could not be attached");}}
      function bind(a,b,c,d){return window.addListener(a,b,function(){d.apply(c,arguments)});}
      //
 
      // Generic dispatcher for keystrokes
      function handleKeystroke(evt) 
      {              
        evt = getEvent(evt);
        var asc = getKeyCode(evt);
        var chr = getCharacter(asc);
 
        for (var i in this)
        {
          if (asc == i)
          {
            this[i](evt);
            break;
          }
        }
      }
      //
 
      // xBrowser event utilities
      function cancelEvent(evt)
      {
        evt.cancelBubble = true;
        evt.returnValue = false;
        if (evt.preventDefault) evt.preventDefault();
        if (evt.stopPropagation) evt.stopPropagation();
        return false;
      }
      function getEvent(evt)
      {
        if( !evt ) evt = window.event;
        return evt;
      }
      function getTarget(evt)
      {
        var target = evt.srcElement ? evt.srcElement : evt.target;
        return target;
      }
      function getKeyCode(evt)
      {
        var asc = !evt.keyCode ? (!evt.which ? evt.charCode : evt.which) : evt.keyCode;
        return asc;
      }
      function getCharacter(asc)
      {
        var chr = String.fromCharCode(asc).toLowerCase();
        return chr;
      }
      //
 
      function handleEnterKey(evt)
      {       
        var target = getTarget(evt);
        var targetTabIndex = target.tabIndex;
        var nextTabIndex = targetTabIndex+1;
 
        var nextElement = getElementByTabIndex(nextTabIndex);
        if( nextElement )
        {
          nextElement.focus();
		  if(nextElement.type=='text')
		  nextElement.select();
          return cancelEvent(evt);
        }
 
        return true;
      }
 
      function getElementByTabIndex(tabIndex)
      {
        var form = document.cashsales;
        for( var i=0; i<form.elements.length; i++ )
        {
          var el = form.elements[i];
          if( el.tabIndex && el.tabIndex == tabIndex )
          {
            return el;
          }
        }
 
        return null;
      }
 
      // Setup our Key Commands
      var keyMap    = new Array();
      var ENTER     = 13 // ASCII code
      keyMap[ENTER] = handleEnterKey;
 
      // Add the keypress listner to the document object for global capture
      bind(document, 'keypress', keyMap, handleKeystroke);
   