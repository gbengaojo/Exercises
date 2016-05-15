(function ($) {

    var hookProperties = {};

    function CSS() {
        this.clearStack();
    }

    CSS.prototype.set = function (elements, property, value, unit) {

        if (!elements.length) {
            elements = [elements];
        }
        for (var i = 0; i < elements.length; i++) {
            var element = elements[i];

            var index = $.inArray(element, this.elements);
            if (index == -1) {
                index = this.elements.push(element) - 1;
                this.stack[index] = {};
            }
            if (unit != '') {
                value += unit;
            }
            this.stack[index][property] = value;
        }
        if (!this.registeredToTick) {
            var that = this;
            N2A.RAF.addPostTick(function () {
                that.flush();
            });
            this.registeredToTick = true;
            if(!N2A.RAF._isTicking){
                N2A.RAF.postTick();
            }
        }
    };

    CSS.prototype.flush = function () {
        //Flush the CSS modifications to the elements
        for (var j = 0; j < this.elements.length; j++) {
            var element = this.elements[j];
            for (var property in this.prepareStack(element, this.stack[j])) {
                var prefixed = nModernizr.prefixed(property);
                if (prefixed) {
                    element.style[prefixed] = this.stack[j][property];
                }
            }
        }

        this.clearStack();
    };

    CSS.prototype.prepareStack = function (element, styles) {
        for (var property in styles) {
            if (typeof hookProperties[property] !== 'undefined') {
                hookProperties[property](element).prepare(styles);
            }
        }
        return styles;
    };

    CSS.prototype.clearStack = function () {
        this.registeredToTick = false;
        this.elements = [];
        this.stack = [];
    };

    var cache = [];

    CSS.prototype.makeTransitionData = function (element, property, startValue, endValue) {
        var unit, unitFrom, unitTo, separatedStartValue, separatedEndValue;
        if (property.match(/transformOrigin|perspective/)) {
            if (endValue) {
                return {
                    startValue: endValue,
                    endValue: endValue,
                    unit: '',
                    range: 0
                }
            } else if (startValue) {
                return {
                    startValue: startValue,
                    endValue: startValue,
                    unit: '',
                    range: 0
                }
            }
        }

        if (typeof startValue === 'undefined') {
            startValue = this.getProperty(element, property);
        }
        separatedStartValue = this.separateValue(property, startValue);
        startValue = separatedStartValue[0];
        unitFrom = separatedStartValue[1];


        if (typeof endValue === 'undefined') {
            endValue = this.getProperty(element, property);
        }
        separatedEndValue = this.separateValue(property, endValue);
        endValue = separatedEndValue[0];
        unitTo = separatedEndValue[1];

        unit = unitTo || unitFrom;

        if (unitTo != unit) {
            endValue = this.transformUnit(element, property, endValue, unitTo, unit);
        }

        if (unitFrom != unit) {
            startValue = this.transformUnit(element, property, startValue, unitFrom, unit);
        }

        return {
            startValue: startValue,
            endValue: endValue,
            unit: unit,
            range: endValue - startValue
        }
    };

    CSS.prototype.getProperty = function (element, property) {
        if (typeof hookProperties[property] !== 'undefined') {
            return hookProperties[property](element).get(property);
        }
        var prefixed = nModernizr.prefixed(property);
        if (prefixed) {
            var value = $(element).css(property);
            if (value == 'auto') {
                return 0;
            }
            return value;
        }

    }

    CSS.prototype.transformUnit = function (element, property, value, startUnit, endUnit) {
        if (value == 0) {
            return 0;
        }
        var parentProperty = '';
        switch (property) {
            case 'left':
            case 'right':
                parentProperty = 'width';
                break;
            case 'top':
            case 'bottom':
                parentProperty = 'height';
                break;
            default:
                parentProperty = property;
        }
        if (startUnit == 'px' && endUnit == '%') {
            var parentValue = this.getProperty(element.parent(), parentProperty),
                separatedParentValue = this.separateValue(parentProperty, parentValue);
            return value / separatedParentValue[0] * 100;
        } else if (startUnit == '%' && endUnit == 'px') {
            var parentValue = this.getProperty(element.parent(), parentProperty),
                separatedParentValue = this.separateValue(parentProperty, parentValue);
            return value / 100 * separatedParentValue[0];
        }
        return value;
    }

    CSS.prototype.parsePropertyValue = function (element, valueData) {
        var endValue = undefined,
            startValue = undefined;

        /* Handle the array format, which can be structured as one of three potential overloads:
         A) [ endValue, easing, startValue ], B) [ endValue, easing ], or C) [ endValue, startValue ] */
        if (N2A.isArray(valueData)) {
            /* endValue is always the first item in the array. Don't bother validating endValue's value now
             since the ensuing property cycling logic does that. */
            endValue = valueData[0];
            startValue = valueData[1];
            /* Handle the single-value format. */
        } else {
            endValue = valueData;
        }

        /* If functions were passed in as values, pass the function the current element as its context,
         plus the element's index and the element set's size as arguments. Then, assign the returned value. */
        if (N2A.isFunction(endValue)) {
            endValue = endValue.call(element);
        }

        if (N2A.isFunction(startValue)) {
            startValue = startValue.call(element);
        }
        /* Allow startValue to be left as undefined to indicate to the ensuing code that its value was not forcefed. */
        return [endValue || 0, startValue];
    };

    CSS.prototype.separateValue = function (property, value) {
        var unitType,
            numericValue;

        numericValue = (value || "0")
            .toString()
            .toLowerCase()
            /* Match the unit type at the end of the value. */
            .replace(/[%A-z]+$/, function (match) {
                /* Grab the unit type. */
                unitType = match;

                /* Strip the unit type off of value. */
                return "";
            });
        /* If no unit type was supplied, assign one that is appropriate for this property (e.g. "deg" for rotateZ or "px" for width). */
        if (!unitType) {
            unitType = this.getUnitType(property);
        }

        return [parseFloat(numericValue), unitType];
    };

    CSS.prototype.getUnitType = function (property) {
        if (/(^(x|y|z|rotationX|rotationY|rotationZ|scale|scaleX|scaleY|opacity)$)/i.test(property)) {
            /* The above properties are unitless. */
            return "";
        } else {
            /* Default to px for all other properties. */
            return "px";
        }
    };

    N2A.CSS = CSS;


    function getTransformObject(element) {
        if (!element.n2Transform) {
            element.n2Transform = new transform();
        }
        return element.n2Transform;
    }

    hookProperties['x'] = getTransformObject;
    hookProperties['y'] = getTransformObject;
    hookProperties['z'] = getTransformObject;
    hookProperties['rotationX'] = getTransformObject;
    hookProperties['rotationY'] = getTransformObject;
    hookProperties['rotationZ'] = getTransformObject;
    hookProperties['scale'] = getTransformObject;
    hookProperties['scaleX'] = getTransformObject;
    hookProperties['scaleY'] = getTransformObject;
    hookProperties['scaleZ'] = getTransformObject;

    function transform(element) {
        this.data = {
            x: 0,
            y: 0,
            z: 0,
            rotationX: 0,
            rotationY: 0,
            rotationZ: 0,
            scaleX: 1,
            scaleY: 1,
            scaleZ: 1,
            scale: 1
        };
    };

    transform.prototype.get = function (property) {
        return this.data[property];
    };


    var rad = Math.PI / 180;
    transform.prototype.prepare = function (styles) {

        if (typeof styles['scale'] !== 'undefined') {
            styles['scaleX'] = styles['scale'];
            styles['scaleY'] = styles['scale'];
            delete styles['scale'];
        }

        for (var k in this.data) {
            if (typeof styles[k] !== 'undefined') {
                this.data[k] = styles[k];
                delete styles[k];
            }
        }

        this.data['scale'] = this.data['scaleX'];

        styles['transform'] = this.matrix3d(this.data.x, this.data.y, this.data.z, this.data.scaleX, this.data.scaleY, this.data.rotationX, this.data.rotationY, this.data.rotationZ);

        return styles;
    };


    transform.prototype.matrix3d = function (x, y, z, scaleX, scaleY, rotateX, rotateY, rotateZ) {
        var Y = Math.cos(rotateX * rad),
            Z = Math.sin(rotateX * rad),
            b = Math.cos(rotateY * rad),
            F = Math.sin(rotateY * rad),
            I = Math.cos(rotateZ * rad),
            P = Math.sin(rotateZ * rad);

        var a = new Array(16);

        a[0] = b * I * scaleX;
        a[1] = -1 * P;
        a[2] = F;
        a[3] = 0;
        a[4] = P;
        a[5] = Y * I * scaleY;
        a[6] = Z;
        a[7] = 0;
        a[8] = -1 * F;
        a[9] = -1 * Z;
        a[10] = b * Y;
        a[11] = 0;
        a[12] = x;
        a[13] = y;
        a[14] = z;
        a[15] = 1;
        return "matrix3d(" + a[0] + "," + a[1] + "," + a[2] + "," + a[3] + "," + a[4] + "," + a[5] + "," + a[6] + "," + a[7] + "," + a[8] + "," + a[9] + "," + a[10] + "," + a[11] + "," + a[12] + "," + a[13] + "," + a[14] + "," + a[15] + ")";
    };
})
(n2);