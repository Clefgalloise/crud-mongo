require('@tensorflow/tfjs-backend-cpu');
require('@tensorflow/tfjs-backend-webgl');

const cocoSsd = require('@tensorflow-models/coco-ssd');

/**
 * @param {File} file
 * @returns {Promise<DetectedObject[]>}
 */
export const detect = async file => {
    const url = URL.createObjectURL(file);
    const image = new Image();

    image.onload = function () {
        URL.revokeObjectURL(this.src);
        document.createElement('canvas').getContext('2d').drawImage(this, 0, 0);
    };

    image.src = url;

    const model = await cocoSsd.load();

    const predictions = await model.detect(image);

    return predictions;
};
