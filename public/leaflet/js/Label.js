function Label(opt_options) {
    this.setValues(opt_options);
    var span = this.span_ = document.createElement('span');
    span.style.cssText = 'position: relative; left: -40%; top: -9px; ' +
                      'white-space: nowrap; border: 0px solid Black; ' +
                      'padding: 2px; Font:Roboto; color:black; background-color:#ffffbb; Font-size:x-small';

    var div = this.div_ = document.createElement('div');
    div.appendChild(span);
    div.style.cssText = 'position: absolute; display: none';
};
Label.prototype = new google.maps.OverlayView;
Label.prototype.onAdd = function () {
    var pane = this.getPanes().overlayLayer;
    pane.appendChild(this.div_);
    var me = this;
    this.listeners_ = [
   google.maps.event.addListener(this, 'position_changed',
       function () { me.draw(); }),
   google.maps.event.addListener(this, 'text_changed',
       function () { me.draw(); })
 ];
};
Label.prototype.onRemove = function() {
    try { this.div_.parentNode.removeChild(this.div_); } catch (Error) { }
    for (var i = 0, I = this.listeners_.length; i < I; ++i) {
        try { google.maps.event.removeListener(this.listeners_[i]); } catch (Error) { }
    }
};
Label.prototype.draw = function() {
    var projection = this.getProjection();
    var position = projection.fromLatLngToDivPixel(this.get('position'));
    var div = this.div_;
    try {
        div.style.left = position.x + 'px';
        div.style.top = position.y + 'px';
        div.style.display = 'block';
        this.span_.innerHTML = this.get('text').toString();
    }
    catch (Error)
    { }
};