<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.png">
    <title>Results In Performance</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f1f5f9;
            color: #172b40;
            font-family: Arial, sans-serif;
        }

        main {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            margin-bottom: 18px;
            border-radius: 12px;
            border: 1px solid #dbe4ed;
        }

        .layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 18px;
        }

        .buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 12px 0;
        }

        button,
        .file-button {
            border: none;
            border-radius: 7px;
            padding: 11px 14px;
            background: #087f76;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        .secondary {
            background: #e7eff5;
            color: #172b40;
        }

        .danger {
            background: #a93442;
        }

        button:disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        .file-button input {
            display: none;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #bdcbd6;
            border-radius: 7px;
            margin-top: 8px;
        }

        .stage {
            position: relative;
            background: #101e2b;
            overflow: hidden;
            border-radius: 8px;
        }

        video,
        img {
            display: block;
            width: 100%;
            height: auto;
        }

        canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        canvas.editing {
            pointer-events: auto;
            cursor: crosshair;
            touch-action: none;
        }

        [hidden] {
            display: none !important;
        }

        #placeholder {
            color: white;
            text-align: center;
            padding: 70px 20px;
        }

        #status {
            padding: 12px;
            background: #edf7f6;
            border-radius: 8px;
            white-space: pre-wrap;
        }

        #editHelp {
            line-height: 1.5;
            color: #785900;
        }

        .measurement {
            padding: 12px 0;
            border-bottom: 1px solid #e4ebf0;
        }

        .measurement-line {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        small {
            display: block;
            color: #627587;
            margin-top: 5px;
        }

        .muted {
            color: #627587;
            font-size: 13px;
            line-height: 1.5;
        }

        #filename {
            overflow-wrap: anywhere;
        }

        @media (max-width: 850px) {
            .layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <main>
        <h1>Medición de ángulos</h1>

        <section class="card">
            <div class="buttons">
                <label class="file-button">
                    Cargar video
                    <input id="videoInput" type="file" accept="video/*">
                </label>

                <label class="file-button">
                    Cargar imagen
                    <input id="imageInput" type="file" accept="image/*">
                </label>
            </div>

            <p id="filename">Sin archivo seleccionado.</p>

            <p id="status" role="status">
                Carga una imagen o reproduce un video y páusalo.
            </p>
        </section>

        <div class="layout">
            <section class="card">
                <div class="stage">
                    <div id="placeholder">
                        Aquí aparecerá el archivo.
                    </div>

                    <video
                        id="video"
                        controls
                        playsinline
                        preload="auto"
                        hidden></video>

                    <img
                        id="image"
                        alt="Imagen para medir ángulos"
                        hidden>

                    <canvas id="overlay"></canvas>
                </div>

                <p class="muted">
                    El video se mide al pausarlo. Si mueves el reproductor
                    mientras está pausado, se analiza la nueva postura.
                </p>

                <div class="buttons">
                    <button id="recalculate" class="secondary" disabled>
                        Volver a analizar con IA
                    </button>

                    <button id="capture" class="secondary" disabled>
                        Descargar captura
                    </button>
                </div>

                <p class="muted">
                    Volver a analizar reemplaza las correcciones de esta postura.
                </p>
            </section>

            <aside class="card">
                <h2>Ángulos</h2>

                <div id="measurements">
                    Sin mediciones.
                </div>

                <h3>Revisar una medición</h3>

                <label for="joint">Selecciona el ángulo:</label>

                <select id="joint">
                    <option value="codo_izquierdo">Codo izquierdo</option>
                    <option value="codo_derecho">Codo derecho</option>
                    <option value="rodilla_izquierda">Rodilla izquierda</option>
                    <option value="rodilla_derecha">Rodilla derecha</option>
                    <option value="tronco">Inclinación del tronco</option>
                </select>

                <div class="buttons">
                    <button id="hideJoint" class="danger" disabled>
                        Está oculta / descartar
                    </button>

                    <button id="correct" class="secondary" disabled>
                        Corregir puntos
                    </button>

                    <button id="cancelCorrection" class="secondary" hidden>
                        Cancelar corrección
                    </button>
                </div>

                <p id="editHelp"></p>

                <div class="buttons">
                    <button id="save" disabled>
                        Guardar en consola
                    </button>
                </div>

                <p class="muted">
                    Abre F12 → Consola para ver el JSON.
                </p>

                <p class="muted">
                    Ángulos en 2D. Codos y rodillas: ángulo interno,
                    extendido ≈ 180°. Tronco: inclinación respecto a
                    la vertical, erguido ≈ 0°.
                </p>

                <p class="muted">
                    Las mediciones automáticas requieren revisión visual.
                    Una articulación oculta debe descartarse.
                </p>
            </aside>
        </div>
    </main>

    <script type="module">
        const $ = id => document.getElementById(id);

        const video = $("video");
        const image = $("image");
        const canvas = $("overlay");
        const ctx = canvas.getContext("2d");

        const VERSION = "0.10.32";

        const BASE =
            `https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@${VERSION}`;

        const MODEL =
            "https://storage.googleapis.com/mediapipe-models/" +
            "pose_landmarker/pose_landmarker_full/float16/1/" +
            "pose_landmarker_full.task";

        /*
         * Filtro más estricto que en la primera versión.
         * Sigue siendo necesaria la revisión visual.
         */
        const MIN_VISIBILITY = 0.85;

        const definitions = {
            codo_izquierdo: {
                name: "Codo izquierdo",
                indexes: [11, 13, 15],
                instructions: ["hombro izquierdo", "codo izquierdo", "muñeca izquierda"]
            },

            codo_derecho: {
                name: "Codo derecho",
                indexes: [12, 14, 16],
                instructions: ["hombro derecho", "codo derecho", "muñeca derecha"]
            },

            rodilla_izquierda: {
                name: "Rodilla izquierda",
                indexes: [23, 25, 27],
                instructions: ["cadera izquierda", "rodilla izquierda", "tobillo izquierdo"]
            },

            rodilla_derecha: {
                name: "Rodilla derecha",
                indexes: [24, 26, 28],
                instructions: ["cadera derecha", "rodilla derecha", "tobillo derecho"]
            },

            tronco: {
                name: "Inclinación del tronco",
                instructions: ["centro de las caderas", "centro de los hombros"]
            }
        };

        let model = null;
        let modelPromise = null;

        let file = null;
        let fileType = null;
        let objectUrl = null;
        let ready = false;

        let snapshot = null;
        let measurements = null;

        let revision = 0;
        let timer = null;

        let correction = null;

        function status(message) {
            $("status").textContent = message;
        }

        function canAnalyze() {
            if (!ready) return false;

            if (fileType === "imagen") {
                return image.complete && image.naturalWidth > 0;
            }

            return (
                fileType === "video" &&
                video.paused &&
                !video.seeking &&
                video.readyState >= 2 &&
                video.videoWidth > 0
            );
        }

        function updateButtons() {
            const hasResult = measurements !== null;
            const editing = correction !== null;

            $("recalculate").disabled = !canAnalyze() || editing;
            $("capture").disabled = !snapshot || editing;
            $("hideJoint").disabled = !hasResult || editing;
            $("correct").disabled = !hasResult || editing;
            $("save").disabled = !hasResult || editing;

            $("joint").disabled = editing;
            $("cancelCorrection").hidden = !editing;
        }

        function stopCorrection() {
            correction = null;

            canvas.classList.remove("editing");
            $("editHelp").textContent = "";

            updateButtons();
        }

        function invalidate() {
            revision++;

            clearTimeout(timer);

            stopCorrection();

            snapshot = null;
            measurements = null;

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            $("measurements").textContent = "Sin mediciones.";

            updateButtons();
        }

        function scheduleAnalysis() {
            if (!canAnalyze()) return;

            invalidate();

            timer = setTimeout(analyze, 100);
        }

        async function getModel() {
            if (model) return model;

            if (!modelPromise) {
                modelPromise = (async () => {
                    const {
                        FilesetResolver,
                        PoseLandmarker
                    } =
                    await import(`${BASE}/vision_bundle.mjs`);

                    const fileset = await FilesetResolver.forVisionTasks(
                        `${BASE}/wasm`
                    );

                    return PoseLandmarker.createFromOptions(fileset, {
                        baseOptions: {
                            modelAssetPath: MODEL,
                            delegate: "CPU"
                        },

                        /*
                         * Analizamos una imagen fija o un fotograma pausado.
                         */
                        runningMode: "IMAGE",
                        numPoses: 1,

                        minPoseDetectionConfidence: 0.6,
                        minPosePresenceConfidence: 0.6
                    });
                })();
            }

            try {
                model = await modelPromise;
                return model;
            } catch (error) {
                modelPromise = null;
                throw error;
            }
        }

        function openFile(selectedFile, type) {
            ready = false;
            fileType = null;

            invalidate();

            video.pause();
            video.removeAttribute("src");
            video.load();

            image.removeAttribute("src");

            if (objectUrl) URL.revokeObjectURL(objectUrl);

            file = selectedFile;
            fileType = type;
            objectUrl = URL.createObjectURL(file);

            $("filename").textContent = file.name;
            $("placeholder").hidden = true;

            video.hidden = type !== "video";
            image.hidden = type !== "imagen";

            if (type === "video") {
                video.src = objectUrl;
                status("Cargando video. Reprodúcelo y páusalo para medir.");
            } else {
                image.src = objectUrl;
                status("Cargando imagen…");
            }
        }

        $("videoInput").addEventListener("change", event => {
            const selected = event.target.files[0];

            if (selected) openFile(selected, "video");

            event.target.value = "";
        });

        $("imageInput").addEventListener("change", event => {
            const selected = event.target.files[0];

            if (selected) openFile(selected, "imagen");

            event.target.value = "";
        });

        image.addEventListener("load", () => {
            if (fileType !== "imagen") return;

            ready = true;

            scheduleAnalysis();
        });

        image.addEventListener("error", () => {
            if (fileType !== "imagen") return;

            ready = false;
            invalidate();

            status("No se pudo abrir la imagen. Prueba JPG, PNG o WebP.");
        });

        video.addEventListener("loadeddata", () => {
            if (fileType !== "video") return;

            ready = true;

            updateButtons();

            status("Video listo. Reprodúcelo y páusalo para medir.");
        });

        video.addEventListener("play", () => {
            if (fileType !== "video") return;

            invalidate();

            status("Pausa el video en la postura que deseas medir.");
        });

        video.addEventListener("pause", () => {
            if (fileType === "video") scheduleAnalysis();
        });

        video.addEventListener("seeking", () => {
            if (fileType !== "video") return;

            invalidate();

            status("Buscando fotograma…");
        });

        video.addEventListener("seeked", () => {
            if (fileType !== "video") return;

            if (video.paused) {
                scheduleAnalysis();
            } else {
                status("Pausa el video para medir.");
            }
        });

        video.addEventListener("ended", () => {
            if (fileType === "video") scheduleAnalysis();
        });

        video.addEventListener("error", () => {
            if (fileType !== "video" || !video.error) return;

            ready = false;
            invalidate();

            status("No se pudo reproducir el video. Prueba MP4 H.264 o WebM.");
        });

        function takeSnapshot() {
            const source = fileType === "video" ? video : image;

            const width = fileType === "video" ?
                video.videoWidth :
                image.naturalWidth;

            const height = fileType === "video" ?
                video.videoHeight :
                image.naturalHeight;

            const scale = Math.min(1, 1280 / Math.max(width, height));

            const result = document.createElement("canvas");

            result.width = Math.max(1, Math.round(width * scale));
            result.height = Math.max(1, Math.round(height * scale));

            result.getContext("2d").drawImage(
                source, 0, 0, result.width, result.height
            );

            return result;
        }

        function validPoint(point) {
            return (
                point &&
                Number.isFinite(point.x) &&
                Number.isFinite(point.y) &&
                Number.isFinite(point.visibility) &&
                point.visibility >= MIN_VISIBILITY &&
                point.x >= 0 &&
                point.x <= canvas.width &&
                point.y >= 0 &&
                point.y <= canvas.height
            );
        }

        function angle(a, b, c) {
            const u = {
                x: a.x - b.x,
                y: a.y - b.y
            };
            const v = {
                x: c.x - b.x,
                y: c.y - b.y
            };

            const denominator =
                Math.hypot(u.x, u.y) * Math.hypot(v.x, v.y);

            if (denominator < 0.000001) return null;

            const cosine = Math.max(
                -1,
                Math.min(1, (u.x * v.x + u.y * v.y) / denominator)
            );

            return Number(
                (Math.acos(cosine) * 180 / Math.PI).toFixed(2)
            );
        }

        function measurementAngle(key, points) {
            if (key === "tronco") {
                const [hips, shoulders] = points;

                return angle(
                    shoulders,
                    hips, {
                        x: hips.x,
                        y: hips.y - 100
                    }
                );
            }

            return angle(...points);
        }

        function emptyMeasurement(reason) {
            return {
                angulo: null,
                origen: null,
                estado: "sin_medicion",
                motivo: reason,
                puntos: []
            };
        }

        function calculateAutomatic(landmarks) {
            const output = {};

            for (const key of Object.keys(definitions)) {
                output[key] = emptyMeasurement(
                    landmarks ?
                    "Puntos con visibilidad insuficiente" :
                    "No se detectó una persona"
                );
            }

            if (!landmarks) return output;

            const points = landmarks.map(point => ({
                x: point.x * canvas.width,
                y: point.y * canvas.height,
                visibility: point.visibility
            }));

            for (const [key, definition] of Object.entries(definitions)) {
                let selectedPoints;

                if (key === "tronco") {
                    /*
                     * El cálculo automático del tronco requiere
                     * ambos hombros y ambas caderas.
                     */
                    if (![11, 12, 23, 24].every(i => validPoint(points[i]))) {
                        continue;
                    }

                    selectedPoints = [{
                            x: (points[23].x + points[24].x) / 2,
                            y: (points[23].y + points[24].y) / 2
                        },
                        {
                            x: (points[11].x + points[12].x) / 2,
                            y: (points[11].y + points[12].y) / 2
                        }
                    ];
                } else {
                    selectedPoints = definition.indexes.map(i => points[i]);

                    if (!selectedPoints.every(validPoint)) continue;
                }

                const value = measurementAngle(key, selectedPoints);

                if (value === null) {
                    output[key] = emptyMeasurement(
                        "Puntos coincidentes: no se puede calcular el ángulo"
                    );
                    continue;
                }

                output[key] = {
                    angulo: value,
                    origen: "ia",
                    estado: "pendiente_revision",
                    motivo: null,
                    puntos: selectedPoints.map(point => ({
                        x: point.x,
                        y: point.y
                    }))
                };
            }

            return output;
        }

        async function analyze() {
            if (!canAnalyze()) return;

            const analysisRevision = ++revision;

            $("recalculate").disabled = true;

            status(
                model ?
                "Calculando ángulos…" :
                "Cargando IA por primera vez…"
            );

            try {
                const detector = await getModel();

                if (
                    analysisRevision !== revision ||
                    !canAnalyze()
                ) {
                    return;
                }

                snapshot = takeSnapshot();

                canvas.width = snapshot.width;
                canvas.height = snapshot.height;

                const detection = detector.detect(snapshot);

                measurements = calculateAutomatic(
                    detection.landmarks?.[0]
                );

                render();

                const validCount = Object.values(measurements).filter(
                    item => item.angulo !== null
                ).length;

                status(
                    validCount ?
                    "Ángulos calculados. Revisa los puntos; descarta los ocultos " +
                    "o corrige sus posiciones." :
                    "Sin ángulos automáticos válidos. Puedes marcar manualmente " +
                    "los puntos de las articulaciones que sí se vean."
                );
            } catch (error) {
                if (analysisRevision !== revision) return;

                console.error(error);

                snapshot = null;
                measurements = null;

                ctx.clearRect(0, 0, canvas.width, canvas.height);
                $("measurements").textContent = "Sin mediciones.";

                status("No se pudo analizar: " + error.message);
            } finally {
                if (analysisRevision === revision) updateButtons();
            }
        }

        function drawPoints(points, color) {
            if (!points.length) return;

            const scale = Math.max(0.8, canvas.width / 900);

            ctx.strokeStyle = color;
            ctx.fillStyle = color;
            ctx.lineWidth = 3 * scale;

            ctx.beginPath();
            ctx.moveTo(points[0].x, points[0].y);

            for (let i = 1; i < points.length; i++) {
                ctx.lineTo(points[i].x, points[i].y);
            }

            ctx.stroke();

            for (const point of points) {
                ctx.beginPath();
                ctx.arc(point.x, point.y, 5 * scale, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        function drawLabel(text, point, color) {
            const scale = Math.max(0.8, canvas.width / 900);

            ctx.font = `bold ${15 * scale}px Arial`;
            ctx.textBaseline = "top";

            const padding = 5 * scale;
            const width = ctx.measureText(text).width + padding * 2;
            const height = 26 * scale;

            const x = Math.max(
                0, Math.min(point.x + 8, canvas.width - width)
            );

            const y = Math.max(
                0, Math.min(point.y - height, canvas.height - height)
            );

            ctx.fillStyle = "rgba(0,0,0,0.8)";
            ctx.fillRect(x, y, width, height);

            ctx.fillStyle = color;
            ctx.fillText(text, x + padding, y + padding);
        }

        function render() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const container = $("measurements");
            container.replaceChildren();

            if (!measurements) {
                container.textContent = "Sin mediciones.";
                return;
            }

            for (const [key, definition] of Object.entries(definitions)) {
                const item = measurements[key];

                const row = document.createElement("div");
                const line = document.createElement("div");
                const name = document.createElement("span");
                const value = document.createElement("strong");
                const info = document.createElement("small");

                row.className = "measurement";
                line.className = "measurement-line";

                name.textContent = definition.name;

                value.textContent = item.angulo === null ?
                    "Sin medición" :
                    item.angulo.toFixed(1) + "°";

                info.textContent = item.estado === "descartada" ?
                    "Descartada por el usuario" :
                    item.angulo === null ?
                    item.motivo :
                    item.origen === "manual" ?
                    "Puntos marcados manualmente" :
                    "IA: pendiente de revisión visual";

                line.append(name, value);
                row.append(line, info);
                container.append(row);

                if (
                    item.angulo === null ||
                    (correction && correction.key === key)
                ) {
                    continue;
                }

                const color = item.origen === "manual" ?
                    "#ffc857" :
                    "#34e3b8";

                drawPoints(item.puntos, color);

                if (key === "tronco") {
                    const hips = item.puntos[0];

                    ctx.save();
                    ctx.setLineDash([6, 6]);
                    ctx.strokeStyle = color;
                    ctx.beginPath();
                    ctx.moveTo(hips.x, hips.y);
                    ctx.lineTo(hips.x, hips.y - canvas.height * 0.15);
                    ctx.stroke();
                    ctx.restore();
                }

                drawLabel(
                    `${definition.name}: ${item.angulo.toFixed(1)}°`,
                    item.puntos[1],
                    color
                );
            }

            if (correction) {
                drawPoints(correction.points, "#ff8a50");
            }

            updateButtons();
        }

        $("recalculate").addEventListener("click", scheduleAnalysis);

        $("hideJoint").addEventListener("click", () => {
            if (!measurements) return;

            const key = $("joint").value;

            measurements[key] = {
                angulo: null,
                origen: "usuario",
                estado: "descartada",
                motivo: "Articulación oculta o puntos incorrectos",
                puntos: []
            };

            render();

            status(
                definitions[key].name +
                " descartado. Su ángulo se guardará como null."
            );
        });

        function showCorrectionStep() {
            if (!correction) return;

            const definition = definitions[correction.key];
            const step = correction.points.length;

            $("editHelp").textContent =
                `Haz clic en ${definition.instructions[step]} ` +
                `(${step + 1} de ${definition.instructions.length}). ` +
                "Marca solamente puntos que puedas identificar visualmente.";
        }

        $("correct").addEventListener("click", () => {
            if (!measurements || !snapshot) return;

            correction = {
                key: $("joint").value,
                points: []
            };

            canvas.classList.add("editing");

            showCorrectionStep();
            render();
        });

        $("cancelCorrection").addEventListener("click", () => {
            stopCorrection();
            render();

            status("Corrección cancelada. Se conserva la medición anterior.");
        });

        canvas.addEventListener("pointerdown", event => {
            if (!correction) return;

            event.preventDefault();

            const rect = canvas.getBoundingClientRect();

            /*
             * Convierte el clic visible a coordenadas reales del canvas.
             */
            const point = {
                x: Math.max(
                    0,
                    Math.min(
                        canvas.width,
                        (event.clientX - rect.left) * canvas.width / rect.width
                    )
                ),

                y: Math.max(
                    0,
                    Math.min(
                        canvas.height,
                        (event.clientY - rect.top) * canvas.height / rect.height
                    )
                )
            };

            correction.points.push(point);

            const definition = definitions[correction.key];

            if (correction.points.length < definition.instructions.length) {
                showCorrectionStep();
                render();
                return;
            }

            const key = correction.key;
            const points = correction.points;
            const value = measurementAngle(key, points);

            if (value === null) {
                correction.points = [];

                showCorrectionStep();
                render();

                status("Los puntos coinciden. Vuelve a marcarlos.");
                return;
            }

            measurements[key] = {
                angulo: value,
                origen: "manual",
                estado: "marcada_por_usuario",
                motivo: null,
                puntos: points.map(point => ({
                    ...point
                }))
            };

            stopCorrection();
            render();

            status(definition.name + " corregido con los puntos que marcaste.");
        });

        $("save").addEventListener("click", () => {
            if (!measurements || correction) return;

            const angles = {};
            const detail = {};

            for (const [key, item] of Object.entries(measurements)) {
                angles[key] = item.angulo;

                detail[key] = {
                    origen: item.origen,
                    estado: item.estado,
                    motivo: item.motivo,

                    /*
                     * Puntos normalizados para poder recuperarlos
                     * aunque cambie el tamaño de la imagen.
                     */
                    puntos: item.puntos.map(point => ({
                        x: point.x / canvas.width,
                        y: point.y / canvas.height
                    }))
                };
            }

            const data = {
                archivo: file.name,
                tipo: fileType,
                unidad: "grados",
                dimension: "2D",

                convencion: {
                    codos_rodillas: "angulo_interno",
                    tronco: "inclinacion_respecto_vertical"
                },

                angulos: angles,
                detalle: detail
            };

            const json = JSON.stringify(data, null, 2);

            console.log("Ángulos:", JSON.parse(json));
            console.log("JSON:\n" + json);

            status("JSON mostrado en F12 → Consola.");
        });

        $("capture").addEventListener("click", () => {
            if (!snapshot || correction) return;

            const result = document.createElement("canvas");

            result.width = canvas.width;
            result.height = canvas.height;

            const resultContext = result.getContext("2d");

            resultContext.drawImage(snapshot, 0, 0);
            resultContext.drawImage(canvas, 0, 0);

            result.toBlob(blob => {
                if (!blob) return;

                const url = URL.createObjectURL(blob);
                const link = document.createElement("a");

                link.href = url;
                link.download = "angulos.png";

                document.body.append(link);
                link.click();
                link.remove();

                setTimeout(() => URL.revokeObjectURL(url), 1000);
            }, "image/png");
        });

        updateButtons();
    </script>
</body>

</html>